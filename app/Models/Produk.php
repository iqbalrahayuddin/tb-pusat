<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'id_saas',
        'nama_produk',
        'id_produk', // Ditambahkan
        'kategori_id',
        // 'stok', 'harga_beli', 'harga_jual' dihapus
    ];

    /**
     * Mendapatkan kategori produk.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}