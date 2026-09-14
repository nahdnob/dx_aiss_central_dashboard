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
        Schema::create('sensor_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('line_id')
                  ->constrained('lines')
                  ->onDelete('cascade');
            $table->foreignId('sensor_summary_id')
                  ->constrained('sensor_summaries')
                  ->onDelete('cascade')
                  ->nullable();
            $table->foreignId('pattern_id')
                  ->constrained()
                  ->onDelete('cascade')
                  ->nullable(); 
            $table->foreignId('sensor_id')
                  ->constrained()
                  ->onDelete('cascade')
                  ->nullable();
            $table->timestamp('time');
            $table->float('duration')
                  ->nullable();
            $table->string('reason')
                  ->nullable();
            $table->boolean('status')
                  ->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_histories');
    }
};
