<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'loginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');



/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource(
        'admin/mahasiswa',
        MahasiswaController::class
    )->names('admin.mahasiswa');

});



/*
|--------------------------------------------------------------------------
| MAHASISWA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Mahasiswa'])->group(function () {

    Route::get('/mahasiswa/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('mahasiswa.dashboard');

    Route::get(
        '/mahasiswa/profile',
        [ProfileController::class, 'index']
    )->name('mahasiswa.profile');

    Route::get(
        '/mahasiswa/profile/edit',
        [ProfileController::class, 'edit']
    )->name('mahasiswa.profile.edit');

    Route::put(
        '/mahasiswa/profile',
        [ProfileController::class, 'update']
    )->name('mahasiswa.profile.update');

});
