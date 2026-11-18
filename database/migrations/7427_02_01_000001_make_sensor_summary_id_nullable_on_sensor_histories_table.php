<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Node-RED inserts sensor_histories rows before a summary exists;
 * CompletingDataService fills sensor_summary_id later, so it must be nullable.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sensor_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('sensor_summary_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('sensor_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('sensor_summary_id')->nullable(false)->change();
        });
    }
};
