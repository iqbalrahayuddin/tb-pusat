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
        // Perintah --create=suppliers sudah membuatkan ini
        Schema::create('suppliers', function (Blueprint $table) { 
            
            // Ini adalah kolom-kolom yang perlu Anda tambahkan
            $table->id();
            $table->string('id_saas'); // Kolom untuk ID SaaS dari user
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();

            // Index untuk pencarian cepat
            $table->index('id_saas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};