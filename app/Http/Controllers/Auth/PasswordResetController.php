<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Mail\PasswordResetOtpMail;
use App\Models\User; // Pastikan Anda import model User
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Menampilkan view untuk memasukkan email (lupa password).
     */
    public function create()
    {
        // Akan mengarah ke resources/views/auth/forgot-password.blade.php
        return view('auth.forgot-password');
    }

    /**
     * Mengirim OTP ke email pengguna.
     */
    public function sendOtp(Request $request)
    {
        // 1. Validasi email
        $request->validate(['email' => 'required|email']);

        // 2. Cek apakah user ada
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            // Beri pesan sukses palsu untuk keamanan (agar orang tidak bisa menebak email)
            // Atau Anda bisa beri pesan error:
            throw ValidationException::withMessages([
                'email' => __('Kami tidak dapat menemukan pengguna dengan alamat email tersebut.'),
            ]);
        }

        // 3. Hapus token/OTP lama jika ada
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // 4. Buat OTP (6 digit)
        $otp = (string) rand(100000, 999999);

        // 5. Simpan HASH dari OTP ke database, bukan OTP-nya
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($otp), // Hash OTP-nya
            'created_at' => now()
        ]);

        // 6. Kirim email berisi OTP (plain text)
        try {
            Mail::to($request->email)->send(new PasswordResetOtpMail($otp));
        } catch (\Exception $e) {
            // Gagal kirim email
            throw ValidationException::withMessages([
                'email' => 'Gagal mengirim email OTP. Coba lagi nanti.',
            ]);
        }

        // 7. Redirect ke halaman reset password (tempat memasukkan OTP)
        // Kita kirim email-nya via query string agar form-nya terisi otomatis
        return redirect()->route('password.reset', ['email' => $request->email])
                         ->with('status', 'Kami telah mengirimkan kode OTP ke email Anda!');
    }

    /**
     * Menampilkan form untuk memasukkan OTP dan password baru.
     */
    public function resetForm(Request $request)
    {
        // Ambil email dari query string
        $email = $request->query('email');
        
        if (! $email) {
            // Jika tidak ada email, kembalikan ke halaman forgot password
            return redirect()->route('password.request');
        }

        // Akan mengarah ke resources/views/auth/reset-password.blade.php
        return view('auth.reset-password', ['email' => $email]);
    }


    /**
     * Memproses reset password.
     */
    public function resetPassword(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|min:6|max:6',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' akan cek 'password_confirmation'
        ]);

        // 2. Cari token/OTP di database
        $tokenData = DB::table('password_reset_tokens')
                        ->where('email', $request->email)
                        ->first();

        // 3. Cek apakah token ada dan OTP-nya cocok
        if (! $tokenData || ! Hash::check($request->otp, $tokenData->token)) {
            throw ValidationException::withMessages([
                'otp' => __('Kode OTP tidak valid.'),
            ]);
        }

        // 4. Cek apakah OTP sudah kedaluwarsa (misal: 10 menit)
        $expiresAt = Carbon::parse($tokenData->created_at)->addMinutes(10);
        
        if (Carbon::now()->isAfter($expiresAt)) {
            // Hapus token lama
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            throw ValidationException::withMessages([
                'otp' => __('Kode OTP telah kedaluwarsa. Silakan minta yang baru.'),
            ]);
        }

        // 5. Cari user
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            throw ValidationException::withMessages([
                'email' => __('Email tidak ditemukan.'),
            ]);
        }

        // 6. Update password user
        $user->password = Hash::make($request->password);
        $user->save();

        // 7. Hapus token dari database setelah berhasil digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // 8. Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Password Anda telah berhasil direset!');
    }
}