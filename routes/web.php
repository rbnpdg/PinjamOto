<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\mobilController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\userController;

Route::get('/', function () {
    return view('home');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/daftar-mobil', [HomeController::class, 'cars'])->name('cars');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');





Route::get('/admin/dashboard', [loginController::class, 'adminDash'])->name('dash-admin');

Route::get('/mobil', [mobilController::class, 'show'])->name('mobil-show');
Route::get('/mobil/tambah', [mobilController::class, 'tambah'])->name('mobil-add');
Route::post('/mobil/store', [mobilController::class, 'store'])->name('mobil-store');
Route::get('/mobil/edit/{mobil}', [mobilController::class, 'edit'])->name('mobil-edit');
Route::put('/mobil/update/{mobil}', [mobilController::class, 'update'])->name('mobil-update');
Route::delete('/mobil/delete/{mobil}', [mobilController::class, 'destroy'])->name('mobil-del');

Route::get('/user', [userController::class, 'show'])->name('user-show');
Route::get('/user/tambah', [userController::class, 'tambah'])->name('user-add');
Route::post('/user/store', [userController::class, 'store'])->name('user-store');
Route::get('/user/edit/{user}', [userController::class, 'edit'])->name('user-edit');
Route::put('/user/update/{user}', [userController::class, 'update'])->name('user-update');

