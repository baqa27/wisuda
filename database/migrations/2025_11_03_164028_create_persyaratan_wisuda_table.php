<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persyaratan_wisuda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis', ['toefl', 'sertifikasi', 'tahfidz', 'bebas_perpus', 'foto_wisuda', 'buku_kenangan']);
            $table->string('file_path');
            $table->enum('status', ['menunggu', 'terverifikasi', 'revisi'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persyaratan_wisuda');
    }
};
