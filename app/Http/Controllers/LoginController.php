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
        // 1. Cek apakah data sampai ke Controller
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            dd("ERROR: Email " . $request->email . " TIDAK DITEMUKAN di tabel tb_login Railway!");
        }

        // 2. Cek apakah password cocok dengan Hash di DB
        $isPasswordCorrect = \Illuminate\Support\Facades\Hash::check($request->password, $user->password);

        if (!$isPasswordCorrect) {
            dd([
                "Pesan" => "Password SALAH!",
                "Password Input" => $request->password,
                "Hash di Database" => $user->password,
                "Panjang Hash" => strlen($user->password)
            ]);
        }

        // 3. Jika Password Benar, Cek Auth Manual
        \Illuminate\Support\Facades\Auth::login($user);

        if (\Illuminate\Support\Facades\Auth::check()) {
            dd("LOGIN BERHASIL! User ID: " . \Illuminate\Support\Facades\Auth::id() . ". Jika kamu melihat pesan ini, berarti masalahnya ada di REDIRECT DASHBOARD kamu.");
        }

        dd("ERROR ANEH: Auth::login jalan tapi Auth::check tetap false. Cek SESSION_DRIVER kamu.");
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
