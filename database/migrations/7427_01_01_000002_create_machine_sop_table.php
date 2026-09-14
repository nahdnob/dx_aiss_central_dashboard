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
        Schema::dropIfExists('machine_documents');

        Schema::create('machine_sop', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')
                  ->constrained('machines')
                  ->cascadeOnDelete();
            $table->foreignId('sop_id')
                  ->constrained('sops')
                  ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['machine_id', 'sop_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_sop');

        Schema::create('machine_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnDelete();
            $table->foreignId('dasg_id')->nullable()->constrained('dasgs')->cascadeOnDelete();
            $table->foreignId('sop_id')->nullable()->constrained('sops')->cascadeOnDelete();
            $table->foreignId('ra_id')->nullable()->constrained('risk_assessments')->cascadeOnDelete();
            $table->timestamps();
        });
    }
};
