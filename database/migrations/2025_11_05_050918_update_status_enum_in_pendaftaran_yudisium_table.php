<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE pendaftaran_yudisium
            MODIFY COLUMN status ENUM('menunggu_pembayaran', 'menunggu_verifikasi', 'lunas', 'batal')
            DEFAULT 'menunggu_pembayaran'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE pendaftaran_yudisium
            MODIFY COLUMN status ENUM('menunggu_pembayaran', 'lunas', 'batal')
            DEFAULT 'menunggu_pembayaran'
        ");
    }
};
