<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_yudisium', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->string('kode_invoice')->unique();
            $table->decimal('total_bayar', 10, 2);
            $table->enum('status', ['menunggu_pembayaran', 'lunas', 'batal'])->default('menunggu_pembayaran');
            $table->datetime('tanggal_bayar')->nullable();
            $table->text('bukti_bayar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_yudisium');
    }
};
