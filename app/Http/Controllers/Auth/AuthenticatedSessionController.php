<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman/view login.
     */
    public function create(): View
    {
        // Akan mengarah ke resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Menangani request POST dari form login.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Siapkan kredensial untuk login
        $credentials = $request->only('email', 'password');
        
        // 3. Ambil nilai "remember me" (Req #2)
        // $request->boolean('remember') akan true jika checkbox dicentang, false jika tidak.
        $remember = $request->boolean('remember');

        // 4. Lakukan upaya login
        // Auth::attempt() secara otomatis menangani "remember me" jika $remember adalah true.
        if (! Auth::attempt($credentials, $remember)) {
            // Jika login gagal
            throw ValidationException::withMessages([
                'email' => __('auth.failed'), // Pesan error standar: "These credentials do not match our records."
            ]);
        }

        // 5. Jika login berhasil, regenerasi session
        $request->session()->regenerate();

        // 6. (Req #3) Redirect ke dashboard
        // Anda tidak perlu menyimpan session secara manual. Laravel sudah melakukannya.
        // Anda bisa akses data user di mana saja dengan `Auth::user()`.
        // Contoh: Auth::user()->nama_toko, Auth::user()->id_saas, dll.
        
        return redirect()->intended('dashboard'); // Redirect ke halaman /dashboard
    }

    /**
     * Menghancurkan session (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/'); // Redirect ke halaman utama
    }
}