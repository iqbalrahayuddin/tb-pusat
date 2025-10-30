<?php
// File: database/migrations/...._create_users_table.php
// (EDIT FILE BAWAAN LARAVEL, JANGAN BUAT BARU)

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
        // 1. Ini adalah tabel USERS yang sudah dimodifikasi
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_saas')->nullable()->index(); // Akan diisi otomatis
            
            // Kolom kustom Anda
            $table->string('nama_toko');
            $table->string('lokasi');
            $table->string('nama_pic'); // Menggantikan 'name'
            
            // Kolom inti Laravel
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); // Diisi otomatis saat register
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Ini adalah tabel bawaan untuk reset password, biarkan saja
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. Ini adalah tabel bawaan untuk session, biarkan saja
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};