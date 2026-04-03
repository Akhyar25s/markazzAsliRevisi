<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Store Face Data (saat registrasi)
Route::post('/store-face-data', [AuthController::class, 'storeFaceData'])->name('store-face-data')->middleware('guest');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Masjid Routes
    Route::middleware('role:admin_masjid')->prefix('admin-masjid')->group(function () {
        Route::get('kelola-pengguna', function () {
            return view('admin.kelola-pengguna');
            })->name('admin-masjid.kelola-pengguna');

        Route::get('rekap-laporan', function () {
            return view('admin.rekap-laporan');
            })->name('admin-masjid.rekap-laporan');
    });

    // Admin Jamaah Routes
    Route::middleware('role:admin_jamaah')->prefix('admin-jamaah')->group(function () {
        Route::get('keaktifan-anggota', function () {
            return view('admin-jamaah.keaktifan-anggota');
        })->name('admin-jamaah.keaktifan-anggota');

        Route::get('rekap-laporan', function () {
            return view('admin-jamaah.rekap-laporan');
        })->name('admin-jamaah.rekap-laporan');

        Route::get('kelompok-itikaf', function () {
            return view('admin-jamaah.kelompok-itikaf');
        })->name('admin-jamaah.kelompok-itikaf');

        Route::get('kelompok-itikaf/buat-jadwal', function () {
            return view('admin-jamaah.buat-jadwal');
        })->name('admin-jamaah.buat-jadwal');
    });
});
