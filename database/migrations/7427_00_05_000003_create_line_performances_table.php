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
        Schema::create('line_performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('line_id')
                  ->constrained('lines')
                  ->onDelete('cascade');
            $table->string('month');
            $table->string('year');
            $table->decimal('target', 10, 1);
            $table->decimal('actual', 10, 1);
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_performances');
    }
};
