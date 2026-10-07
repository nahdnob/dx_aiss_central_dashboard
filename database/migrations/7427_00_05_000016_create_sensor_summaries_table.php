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
        Schema::create('sensor_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('line_id')
                  ->constrained('lines')
                  ->onDelete('cascade');
            $table->foreignId('work_hour_id')
                  ->constrained('work_hours')
                  ->onDelete('cascade');
            $table->foreignId('pattern_id')
                  ->nullable()
                  ->constrained('patterns')
                  ->onDelete('cascade');
            $table->foreignId('sensor_id')
                  ->constrained('sensors')
                  ->onDelete('cascade');
            $table->float('average')
                  ->nullable();
            $table->float('maximal')
                  ->nullable();
            $table->float('minimal')
                  ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_summaries');
    }
};
