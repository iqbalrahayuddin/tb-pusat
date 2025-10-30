<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; // Kita akan gunakan Auth

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard.
     */
    public function index(): View
    {
        // Ini akan memanggil file:
        // resources/views/dashboard.blade.php
        
        // Anda tidak perlu mengirim data user, karena
        // kita bisa panggil Auth::user() langsung di Blade.
        return view('dashboard');
    }
}