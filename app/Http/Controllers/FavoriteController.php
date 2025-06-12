<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggleFavorite(Mobil $mobil)
    {
        if (!Auth::check()) {
            return redirect()->route('login-show')->with('error', 'Anda perlu login untuk menambahkan favorit.');
        }

        $user = Auth::user();

        if ($user->favorites()->where('mobil_id', $mobil->id)->exists()) {
            $user->favorites()->detach($mobil->id);
            $message = 'Mobil dihapus dari favorit.';
            $icon = 'success';
        } else {
            $user->favorites()->attach($mobil->id);
            $message = 'Mobil berhasil ditambahkan ke favorit!';
            $icon = 'success';
        }

        return back()->with($icon, $message);
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login-show')->with('error', 'Anda perlu login untuk melihat daftar favorit.');
        }

        $user = Auth::user();
        $favoriteMobils = $user->favorites()->paginate(9);

        // Pastikan Anda juga meneruskan $pesananAktif jika digunakan di layout atau card
        $pesananAktif = $user->hasActiveOrder(); // Gunakan method dari User model

        return view('konsumen-favorite', compact('favoriteMobils', 'pesananAktif'));
    }
}