<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB; // Import DB Facade

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_toko',
        'lokasi',
        'nama_pic', // Menggantikan 'name'
        'email',
        'password',
        'email_verified_at', // Ditambahkan agar bisa diisi
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * Ini adalah logika untuk mengisi id_saas secara otomatis.
     * Kita menggunakan event 'created' yang berjalan SETELAH pengguna
     * berhasil dibuat dan mendapatkan ID.
     */
    protected static function booted(): void
    {
        static::created(function (User $user) {
            // Menggunakan DB::update agar tidak memicu event 'save'
            // dan menghindari infinite loop.
            DB::table('users')
                ->where('id', $user->id)
                ->update(['id_saas' => $user->id]);
        });
    }
}