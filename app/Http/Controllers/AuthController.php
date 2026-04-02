<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Pelanggan;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Session::get('role') === 'admin') return redirect()->route('penjualan.index');
        if (Session::get('role') === 'pelanggan') return redirect()->route('pelanggan.home');
        return view('login');
    }

public function login(Request $request)
{
    $request->validate([
        'EmailPelanggan' => 'required|string',
        'password'       => 'required|string',
    ]);

    // Ambil input berdasarkan nama field yang benar
    $email    = $request->EmailPelanggan; 
    $password = $request->password;

    // Cek admin (Gunakan variabel $email)
    if ($email === 'admin' && $password === 'admin123') {
        Session::put('role', 'admin');
        Session::put('nama', 'Administrator');
        return redirect()->route('produk.index');
    }

    // Cek pelanggan berdasarkan kolom EmailPelanggan
    $pelanggan = Pelanggan::where('EmailPelanggan', $email)->first();
    
    if ($pelanggan && $pelanggan->password === $password) {
        Session::put('role', 'pelanggan');
        Session::put('pelanggan_id', $pelanggan->PelangganID);
        
        // Simpan NamaPelanggan ke session 'nama' agar muncul di dashboard
        Session::put('nama', $pelanggan->NamaPelanggan); 
        
        return redirect()->route('pelanggan.home');
    }

    return back()->withErrors(['EmailPelanggan' => 'Email atau password salah.'])->withInput();
}
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255|unique:pelanggan,NamaPelanggan',
            'EmailPelanggan'=> 'required|email|unique:pelanggan,EmailPelanggan',
            'NomorTelepon'  => 'nullable|string|max:15',
            'Alamat'        => 'nullable|string',
            'password'      => 'required|string|min:6',
        ], [
            'EmailPelanggan.unique' => 'Email ini sudah terdaftar, gunakan nama lain.',
            'password.min'         => 'Password minimal 6 karakter.',
        ]);

        $pelanggan = Pelanggan::create([
            'NamaPelanggan' => $request->NamaPelanggan,
            'EmailPelanggan' => $request->EmailPelanggan,
            'NomorTelepon'  => $request->NomorTelepon,
            'Alamat'        => $request->Alamat,
            'password'      => $request->password,
        ]);

        // Langsung login setelah daftar
        Session::put('role', 'pelanggan');
        Session::put('pelanggan_id', $pelanggan->PelangganID);
        Session::put('nama', $pelanggan->NamaPelanggan);

        return redirect()->route('pelanggan.home')->with('success', 'Akun berhasil dibuat! Selamat datang 🎀');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}
