<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mobilController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\userController;
use App\Http\Controllers\transaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin-dash');
});

Route::get('/admin/dashboard', [loginController::class, 'adminDash'])->name('dash-admin');

Route::get('/login', [loginController::class, 'show'])->name('login-show');
Route::post('/login/session', [loginController::class, 'login']);
Route::get('/logout', [loginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'cekRole:Admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin-dash');
    });
        
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

    Route::get('/transaksi', [TransaksiController::class, 'show'])->name('transaksi-show');
    Route::get('/transaksi/tambah', [TransaksiController::class, 'tambah'])->name('transaksi-add');
    Route::get('/transaksi/edit', [TransaksiController::class, 'edit'])->name('transaksi-edit');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi-store');
    Route::put('/transaksi/{id}/finish', [TransaksiController::class, 'finish'])->name('transaksi-finish');
    Route::put('/transaksi/{id}/reject', [TransaksiController::class, 'reject'])->name('transaksi-reject');
});

Route::middleware(['auth', 'cekRole:Owner'])->group(function () {
    Route::get('/owner', function () {
        return view('owner-dash');
    });
});

Route::middleware(['auth', 'cekRole:Konsumen'])->group(function () {
    Route::get('/dashboard', function () {
        return view('konsumen-dash');
    });
});

