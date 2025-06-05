<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Mobil;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function adminDash() {
        $jumlahMobil = Mobil::count();
        $jumlahUser = User::where('role', 'Konsumen')->count();
        $jumlahTransaksi = Transaksi::count();

        return view('admin-dash', compact('jumlahMobil', 'jumlahUser', 'jumlahTransaksi'));
    }

    public function ownerDash() {
        $jumlahMobil = Mobil::count();
        $jumlahUser = User::where('role', 'Konsumen')->count();
        $jumlahTransaksi = Transaksi::count();

        return view('owner-dash', compact('jumlahMobil', 'jumlahUser', 'jumlahTransaksi'));
    }

    public function show() {
        return view('login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // if (!$user) {
        //     dd('User tidak ditemukan'); // email tidak cocok
        // }

        // if (!Hash::check($request->password, $user->password)) {
        //     dd('Password tidak cocok', [
        //         'input_password' => $request->password,
        //         'hashed' => $user->password
        //     ]);
        // }

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            session(['role' => $user->role]);

            if ($user->role === 'Admin') {
                return redirect('/admin/dashboard')->with('success', 'Selamat datang!');
            } elseif ($user->role === 'Owner') {
                return redirect('/owner/dashboard')->with('success', 'Selamat datang!');
            } elseif ($user->role === 'Konsumen') {
                return redirect('/home')->with('success', 'Selamat datang!');
            } else {
                return view('/login');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('user-home')->with('success', 'Berhasil Logout!');
    }
}
