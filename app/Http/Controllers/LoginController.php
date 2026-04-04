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
            $request->session()->regenerate();

            // KODE PENGETESAN: Langsung lempar ke dashboard tanpa cek role
            // Jika ini berhasil, berarti masalahnya ada di tulisan "admin" di database kamu
            return redirect()->route('dashboard')->with('success', 'Berhasil Tembus!');

            /* Bagian ini dikomentari dulu sementara
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect()->route('dashboard')->with('success', 'Selamat Datang Admin');
            } elseif ($role === 'user') {
                return redirect()->route('dashboard')->with('success', 'Selamat Datang Pengguna');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak dikenali');
            }
            */
        } else {
            // Jika login gagal (Password/Email salah)
            return redirect()->route('login')->with('error', 'Username atau Password salah')->withInput();
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
