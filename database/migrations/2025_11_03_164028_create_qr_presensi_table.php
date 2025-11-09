<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->string('token')->unique();
            $table->string('kode_unik')->unique(); // Tambahkan kode unik
            $table->string('file_qr')->nullable();
            $table->enum('status', ['aktif', 'digunakan', 'expired'])->default('aktif');
            $table->datetime('waktu_checkin')->nullable();
            $table->datetime('expired_at')->nullable(); // Tambahkan expired time
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_presensi');
    }
};
