<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran_wisuda', function (Blueprint $table) {
            $table->string('status', 20)->change(); // atau 30 untuk lebih aman
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_wisuda', function (Blueprint $table) {
            $table->string('status', 15)->change();
        });
    }
};
