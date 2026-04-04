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
        $credentials = $request->only('email', 'password');

        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            // Ini perintah untuk membuatkan "KTP" Session baru
            $request->session()->regenerate();

            // Paksa redirect ke URL dashboard
            return redirect()->to('/dashboard');
        }

        return back()->with('error', 'Login Gagal');
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
