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
        Schema::table('persyaratan_yudisium', function (Blueprint $table) {
            $table->string('no_whatsapp')->nullable()->after('dosen_pembimbing');
            $table->string('sertifikasi_tahfidz')->nullable()->after('file_ijazah');
            $table->string('sertifikasi_toefl')->nullable()->after('sertifikasi_tahfidz');
            $table->string('surat_bebas_perpustakaan')->nullable()->after('sertifikasi_toefl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persyaratan_yudisium', function (Blueprint $table) {
            $table->dropColumn([
                'no_whatsapp',
                'sertifikasi_tahfidz',
                'sertifikasi_toefl',
                'surat_bebas_perpustakaan'
            ]);
        });
    }
};
