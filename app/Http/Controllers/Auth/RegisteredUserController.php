<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman/view registrasi.
     */
    public function create(): View
    {
        // Kita akan membuat view ini di Langkah 5
        return view('auth.register');
    }

    /**
     * Menangani request POST dari form registrasi.
     */
    public function store(Request $request): RedirectResponse
    {
        // 2. Validasi form (termasuk password confirmation)
        $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'nama_pic' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['accepted'], // 5. Validasi checkbox terms
        ]);

        // 4. Membuat user baru
        $user = User::create([
            'nama_toko' => $request->nama_toko,
            'lokasi' => $request->lokasi,
            'nama_pic' => $request->nama_pic,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Sesuai permintaan di migrasi Anda
        ]);

        // (Logika id_saas akan berjalan otomatis dari Model)

        // Login pengguna setelah berhasil registrasi
        Auth::login($user);

        // Redirect ke halaman dashboard (atau halaman lain)
        return redirect('/dashboard');
    }
}