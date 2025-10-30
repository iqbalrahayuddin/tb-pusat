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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_saas'); // Untuk menyimpan ID SaaS dari user
            $table->string('nomor_nota')->unique(); // TB-K-YYMMDD-XXXX
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->bigInteger('kredit'); // Simpan sebagai angka (misal: 250000)
            $table->string('bukti')->nullable(); // Path ke file bukti
            $table->timestamps();

            // Opsional: Menambahkan foreign key
            // $table->foreign('id_saas')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};