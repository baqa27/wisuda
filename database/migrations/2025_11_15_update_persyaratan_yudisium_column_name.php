<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Menggunakan raw SQL untuk menghindari issue dengan enum default value
        DB::statement('ALTER TABLE persyaratan_yudisium CHANGE COLUMN status_verifikasi status ENUM("menunggu", "terverifikasi", "revisi") CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT "menunggu"');
    }

    public function down(): void
    {
        // Revert: kembalikan ke status_verifikasi
        DB::statement('ALTER TABLE persyaratan_yudisium CHANGE COLUMN status status_verifikasi ENUM("menunggu", "terverifikasi", "revisi") CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT "menunggu"');
    }
};
