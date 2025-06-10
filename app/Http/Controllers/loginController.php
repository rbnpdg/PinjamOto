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

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            session(['role' => $user->role]);

            $welcomeMessage = 'Selamat datang, ' . $user->nama . '!';

            if ($user->role === 'Admin') {
                return redirect('/admin/dashboard')->with('success', $welcomeMessage);
            } elseif ($user->role === 'Owner') {
                return redirect('/owner/dashboard')->with('success', $welcomeMessage);
            } elseif ($user->role === 'Konsumen') {
                return redirect('/home')->with('success', $welcomeMessage);
            } else {
                return redirect('/login')->with('error', 'Role tidak dikenali');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('user-home')->with('success', 'Berhasil Logout!');
    }
}
