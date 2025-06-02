<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function adminDash() {
        return view('admin-dashboard');
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

            if ($user->role === 'Admin') {
                return redirect('/admin');
            } elseif ($user->role === 'Owner') {
                return redirect('/owner');
            } else {
                return redirect('/dashboard');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
