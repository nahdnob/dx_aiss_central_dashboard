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
        Schema::create('product_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('line_id')
                  ->constrained('lines')
                  ->onDelete('cascade');
            $table->foreignId('product_out_id')
                  ->nullable()
                  ->constrained('product_outs')
                  ->onDelete('cascade');
            $table->string('part_id');
            $table->string('part_number');
            $table->dateTime('time_in');
            $table->integer('quantity');
            $table->boolean('is_processed')
                  ->default(0)
                  ->comment('0 = not processed, 1 = processed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ins');
    }
};
