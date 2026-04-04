<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    public function login_proses(Request $request)
    {
        // 1. Cari user berdasarkan email
        $user = \App\Models\User::where('email', $request->email)->first();

        // 2. Cek apakah user ada DAN password MD5-nya cocok
        if ($user && md5($request->password) === $user->password) {

            // 3. Login-kan user secara manual ke sistem Laravel
            \Illuminate\Support\Facades\Auth::login($user);
            $request->session()->regenerate();

            // 4. Langsung lempar ke dashboard
            return redirect()->route('dashboard');
        }

        // Jika gagal
        return back()->with('error', 'Username atau Password salah')->withInput();
    }

    public function logout(Request $request)
    {
        // Hapus status online dari cache
        Cache::forget('user-is-online-' . Auth::id());

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil Logout');
    }
}
