<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanKeuanganController;

/*
|--------------------------------------------------------------------------
| Rute Web
|--------------------------------------------------------------------------
*/

// Rute Welcome (biasanya untuk development atau info)
Route::get('/welcome', function () {
    return view('welcome');
});

// Rute Halaman Utama (/)
// Mengarahkan ke dashboard (jika sudah login) atau ke halaman login (jika belum).
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home'); // Menetapkan nama 'home' untuk rute ini


// --- RUTE OTENTIKASI (UNTUK TAMU / BELUM LOGIN) ---
Route::middleware('guest')->group(function () {
    // Registrasi
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredSessionController::class, 'store']); // Pastikan ini AuthenticatedSessionController jika Anda mengikuti Breeze/Jetstream

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Rute Forgot Password (BARU)
    Route::get('forgot-password', [PasswordResetController::class, 'create'])
                ->name('password.request'); // 'password.request' adalah nama standar Laravel
    
    Route::post('forgot-password', [PasswordResetController::class, 'sendOtp'])
                ->name('password.email'); // 'password.email' adalah nama standar Laravel

    // Rute Reset Password (BARU)
    Route::get('reset-password', [PasswordResetController::class, 'resetForm'])
                ->name('password.reset'); // Halaman untuk memasukkan OTP
                
    Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])
                ->name('password.update'); // 'password.update' adalah nama standar Laravel
});


// --- RUTE YANG MEMERLUKAN OTENTIKASI (LOGIN) ---
// Semua rute yang memerlukan login digabungkan dalam satu grup ini
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Halaman Supplier
    // Menggunakan 'except' agar konsisten dengan rute lain
    Route::resource('supplier', SupplierController::class)->except(['show', 'create', 'edit']);

    // Rute Halaman Kategori
    Route::resource('kategori', KategoriController::class)->except(['show', 'create', 'edit']);

    // Rute Halaman Produk
    // Direfaktorisasi menjadi 'resource' agar konsisten.
    // Ini sudah mencakup: index, store, show, update, destroy
    Route::resource('produk', ProdukController::class)->except(['create', 'edit']);

    // Rute Halaman Toko (Error 'l' sudah dihapus)
    Route::resource('toko', TokoController::class)->except(['show', 'create', 'edit']);
    
    // Rute Halaman Stok (Diasumsikan perlu login)
    Route::get('/stok', function () {
        return view('stok');
    })->name('stok.index'); // Menambahkan nama agar konsisten

    // Rute Halaman Pemasukan
    Route::resource('pemasukan', PemasukanController::class);

    // Rute untuk CRUD Pengeluaran
    Route::resource('pengeluaran', PengeluaranController::class);

    // Rute khusus untuk menampilkan file bukti
    Route::get('pengeluaran/bukti/{id}', [PengeluaranController::class, 'showBukti'])
         ->name('pengeluaran.bukti');

    // Rute untuk Laporan Keuangan
    Route::get('laporan-keuangan', [LaporanKeuanganController::class, 'index'])
         ->name('laporan.keuangan');

    // == RUTE BARU UNTUK DOWNLOAD PDF ==
    Route::get('laporan-keuangan/download', [LaporanKeuanganController::class, 'downloadPDF'])
         ->name('laporan.keuangan.pdf');

    // Rute untuk Cetak PDF (Menampilkan di browser)
    Route::get('laporan-keuangan/cetak', [LaporanKeuanganController::class, 'cetakPDF'])
         ->name('laporan.keuangan.cetak');

});

// Rute Welcome (biasanya untuk development atau info)
Route::get('/transfer-stok', function () {
    return view('transfer-stok');
});

// Rute Welcome (biasanya untuk development atau info)
Route::get('/stok-masuk', function () {
    return view('stok-masuk');
});

