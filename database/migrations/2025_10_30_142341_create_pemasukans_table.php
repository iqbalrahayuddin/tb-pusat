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
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_saas'); // Untuk relasi ke user/tenant Anda
            $table->string('nomor_nota')->unique(); // TB-YYMMDD-XXX
            $table->date('tanggal');
            $table->string('keterangan');
            $table->decimal('debit', 15, 2); // 15 digit total, 2 di belakang koma
            $table->string('bukti')->nullable(); // Path ke file
            $table->timestamps();
            
            // Opsional: tambahkan foreign key jika Anda punya tabel 'saas' atau 'users'
            // $table->foreign('id_saas')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};