<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mobilController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\userController;
use App\Http\Controllers\transaksiController;
use App\Http\Controllers\ownerController;
use App\Http\Controllers\konsumenController;
use App\Http\Controllers\FavoriteController;

Route::get('/', function () {
    return view('konsumen-home');
});

Route::post('/duitku/callback', [TransaksiController::class, 'duitkuCallback'])->name('duitku.callback');
Route::get('/transaksi/{id}/bayar', [TransaksiController::class, 'bayarDuitku'])->name('transaksi.bayar.duitku');

Route::get('/home', [konsumenController::class, 'home'])->name('user-home');
Route::get('/katalog', [konsumenController::class, 'katalog'])->name('mobil-katalog');
Route::get('/kontak', [konsumenController::class, 'kontak'])->name('kontak');

Route::get('/login', [loginController::class, 'show'])->name('login-show');
Route::get('/register', [loginController::class, 'showRegist'])->name('register-show');
Route::post('/register', [loginController::class, 'storeRegist'])->name('register-store');
Route::post('/login/session', [loginController::class, 'login']);
Route::get('/logout', [loginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'cekRole:Admin'])->group(function () {
    Route::get('/admin/dashboard', [loginController::class, 'adminDash'])->name('admin-show');
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

    Route::get('/admin/edit-profile', [userController::class, 'editShow'])->name('admin-edit');
    Route::put('/admin/profil-update', [userController::class, 'updateProfile'])->name('admin-update');

    Route::get('/transaksi', [TransaksiController::class, 'show'])->name('transaksi-show');
    Route::get('/transaksi/tambah', [TransaksiController::class, 'tambah'])->name('transaksi-add');
    Route::get('/transaksi/edit', [TransaksiController::class, 'edit'])->name('transaksi-edit');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi-store');
    Route::put('/transaksi/{id}/finish', [TransaksiController::class, 'finish'])->name('transaksi-finish');
    Route::put('/transaksi/{id}/reject', [TransaksiController::class, 'reject'])->name('transaksi-reject');
    Route::put('/transaksi/{id}/konfirmasi', [TransaksiController::class, 'konfirmasiPembayaran'])->name('transaksi-konfirmasi');
    Route::put('/transaksi/{id}/tolak', [TransaksiController::class, 'tolakPembayaran'])->name('transaksi-tolak');
    Route::post('/transaksi/admin-preview', [TransaksiController::class, 'previewAdmin'])->name('admin-trpreview');
});

Route::middleware(['auth', 'cekRole:Owner'])->group(function () {
    Route::get('/owner/dashboard', [loginController::class, 'ownerDash'])->name('owner-dash');
    Route::get('/owner/mobil', [ownerController::class, 'show'])->name('mobil-owner');
    Route::get('/owner/transaksi', [ownerController::class, 'trShow'])->name('transaksi-owner');
    Route::get('/owner/edit-profile', [ownerController::class, 'editShow'])->name('owner-edit');
    Route::put('/owner/profil-update', [ownerController::class, 'updateProfile'])->name('owner-update');
});

Route::middleware(['auth', 'cekRole:Konsumen'])->group(function () {
    Route::get('/filtered', [konsumenController::class, 'filter'])->name('katalog-filter');
    Route::get('/pesan-{id}', [konsumenController::class, 'pesanShow'])->name('mobil-pesan');

    Route::post('/transaksi/preview', [TransaksiController::class, 'preview'])->name('transaksi.preview');
    Route::get('/bayar/{metode}', [transaksiController::class, 'showPayment'])->name('pembayaran.show');
    Route::post('/transaksi/konfirmasi-bayar', [TransaksiController::class, 'konfirmasiBayar'])->name('transaksi.konfirmasiBayar');

    Route::post('/favorites/{mobil}/toggle', [FavoriteController::class, 'toggleFavorite'])->name('toggle-favorit');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorite');

    Route::get('/user/edit', [konsumenController::class, 'editProfile'])->name('edit-show');
    Route::put('/profil/update', [konsumenController::class, 'updateProfile'])->name('update-profile');
    Route::get('user/histori-transaksi', [konsumenController::class, 'historiShow'])->name('histori-show');
    Route::get('user/histori-transaksi/filtered', [konsumenController::class, 'filterHistori'])->name('filtered-histori');
}); 


