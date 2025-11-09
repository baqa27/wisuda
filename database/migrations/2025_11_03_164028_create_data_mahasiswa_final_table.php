<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_mahasiswa_final', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->string('NIM');
            $table->string('pas_foto');
            $table->string('nama');
            $table->string('prodi');
            $table->decimal('IPK', 3, 2);
            $table->string('nama_ortu_1');
            $table->string('nama_ortu_2');
            $table->string('nama_tamu_1');
            $table->string('nama_tamu_2');
            $table->enum('status', ['proses', 'siap_wisuda'])->default('proses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_mahasiswa_final');
    }
};
