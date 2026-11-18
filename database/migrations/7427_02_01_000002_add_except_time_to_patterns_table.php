<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * except_time: batas bawah data yang ditampilkan. Pembacaan sensor dengan
 * duration < except_time dianggap data sampah (trigger tidak sengaja) dan
 * tidak ditampilkan di chart / log aktivitas. 0 = tidak ada yang disembunyikan.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patterns', function (Blueprint $table) {
            $table->float('except_time')->default(0)->after('min_time');
        });
    }

    public function down(): void
    {
        Schema::table('patterns', function (Blueprint $table) {
            $table->dropColumn('except_time');
        });
    }
};
