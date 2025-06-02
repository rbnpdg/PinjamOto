<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;

class konsumenController extends Controller
{
    public function home()
    {
        $mobil = Mobil::all();
        return view('konsumen-home', compact('mobil'));
    }
}
