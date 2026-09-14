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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('line_id')
                  ->constrained('lines')
                  ->onDelete('cascade');
            $table->string('asset_no')
                  ->unique();
            $table->string('asset_name');
            $table->date('acquisition_date');
            $table->string('image_path')
                  ->nullable();
            $table->string('manufacturer')
                  ->nullable();
            $table->string('model')
                  ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
