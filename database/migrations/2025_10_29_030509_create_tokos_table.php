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
        Schema::create('tokos', function (Blueprint $table) {
            $table->id();
            // 5. Mengisi id_saas secara otomatis (diasumsikan id_saas adalah angka)
            // Kita akan tambahkan foreign key jika 'id_saas' di tabel user adalah ID
            // Jika tidak, kita bisa gunakan unsignedBigInteger dan index.
            // Di sini saya asumsikan tabel users Anda punya kolom 'id_saas'
            // dan kita hanya menyimpan nilainya.
            $table->unsignedBigInteger('id_saas'); 
            
            $table->string('nama_toko');
            $table->string('lokasi');
            $table->string('penanggung_jawab');
            $table->string('nomor_telfon')->nullable(); // Boleh kosong
            $table->timestamps();

            // Tambahkan index untuk pencarian cepat berdasarkan id_saas
            $table->index('id_saas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokos');
    }
};