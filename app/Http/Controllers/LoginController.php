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
        // 1. Ambil input email dan password
        $credentials = $request->only('email', 'password');

        // 2. Gunakan Auth::attempt (Ini akan otomatis mengecek Bcrypt yang ada di foto tadi)
        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // 3. Jika gagal, kasih dd() sebentar buat cek kenapa
        dd([
            "Pesan" => "Auth::attempt GAGAL",
            "Email Input" => $request->email,
            "Cek User di DB" => \App\Models\User::where('email', $request->email)->first()
        ]);
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
