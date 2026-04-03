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
        // Validasi input
        Session::flash('email', $request->email);
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi'
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            // Cek apakah benar login
            if (Auth::check()) {
                $request->session()->regenerate();

                // Redirect langsung ke URL dashboard
                return redirect('/dashboard');
            } else {
                return back()->with('error', 'Session gagal dibuat');
            }
        } else {
            return back()->with('error', 'Username atau Password salah');
        }
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
