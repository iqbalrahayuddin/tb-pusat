<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_saas'); // Untuk multi-tenancy
            $table->string('nama_produk');
            $table->integer('stok')->default(0);
            $table->decimal('harga_beli', 15, 2)->default(0);
            $table->decimal('harga_jual', 15, 2)->default(0);
            
            // Relasi ke tabel suppliers
            $table->foreignId('supplier_id')
                  ->nullable()
                  ->constrained('suppliers')
                  ->onDelete('set null'); // Jika supplier dihapus, produk tetap ada

            // Relasi ke tabel kategoris
            $table->foreignId('kategori_id')
                  ->nullable()
                  ->constrained('kategoris') // Pastikan nama tabel Anda 'kategoris'
                  ->onDelete('set null'); // Jika kategori dihapus, produk tetap ada
            
            $table->timestamps();
            
            // Index untuk mempercepat query
            $table->index('id_saas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};