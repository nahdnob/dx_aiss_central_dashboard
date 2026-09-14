<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dasg_sop', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sop_id')
                  ->constrained('sops')
                  ->onDelete('cascade');
            $table->foreignId('dasg_id')
                  ->constrained('dasgs')
                  ->onDelete('cascade');
            $table->timestamps();
            $table->unique(['sop_id', 'dasg_id']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dasg_sop');
    }
};
