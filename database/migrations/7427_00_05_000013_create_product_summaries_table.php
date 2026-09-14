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
        Schema::create('product_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('line_id')
                  ->constrained('lines')
                  ->onDelete('cascade');
            $table->string('part_number');
            $table->unsignedBigInteger('first_id');
            $table->foreign('first_id')
                  ->references('id')
                  ->on('product_ins')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('last_id');
            $table->foreign('last_id')
                  ->references('id')
                  ->on('product_ins')
                  ->onDelete('cascade');
            $table->integer('qty_in')
                  ->default(0);
            $table->integer('qty_out')
                  ->default(0);
            $table->timestamps();

            $table->unique(['line_id', 'part_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_summaries');
    }
};
