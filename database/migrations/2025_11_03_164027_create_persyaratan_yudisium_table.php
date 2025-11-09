<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persyaratan_yudisium', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->string('judul_ta');
            $table->string('dosen_pembimbing');
            $table->string('file_ktp');
            $table->string('file_ijazah')->nullable();
            $table->enum('status_verifikasi', ['menunggu', 'terverifikasi', 'revisi'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persyaratan_yudisium');
    }
};
