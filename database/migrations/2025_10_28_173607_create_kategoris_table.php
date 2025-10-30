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
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->text('keterangan')->nullable();
            
            // 4. Mengisi 'id_saas' secara otomatis
            // Kita tambahkan kolomnya di sini. Pengisian otomatis akan ada di Controller.
            // Pastikan ini sesuai dengan tipe data di tabel users Anda (misal: bigInteger, uuid)
            $table->unsignedBigInteger('id_saas'); 
            
            $table->timestamps();

            // Opsional: Menambahkan foreign key constraint
            // $table->foreign('id_saas')->references('id_saas')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};