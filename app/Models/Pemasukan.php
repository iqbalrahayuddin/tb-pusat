<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_saas',
        'nomor_nota',
        'tanggal',
        'keterangan',
        'debit',
        'bukti',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal' => 'date', // Otomatis cast ke objek Carbon
        'debit' => 'decimal:2', // Otomatis cast debit
    ];
}