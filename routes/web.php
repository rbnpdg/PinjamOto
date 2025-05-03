<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mobilController;
use App\Http\Controllers\loginController;

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

Route::get('/mobil', [mobilController::class, 'show'])->name('mobil-show');
Route::get('/mobil/tambah', [mobilController::class, 'tambah'])->name('mobil-add');
Route::post('/mobil/store', [mobilController::class, 'store'])->name('mobil-store');
Route::get('/mobil/edit/{mobil}', [mobilController::class, 'edit'])->name('mobil-edit');
Route::put('/mobil/update/{mobil}', [mobilController::class, 'update'])->name('mobil-update');
Route::delete('/mobil/delete/{mobil}', [mobilController::class, 'destroy'])->name('mobil-del');


