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
        Schema::create('follow_up_letters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('inspection_id')->constrained('inspections')->cascadeOnDelete();
            $table->string('file_path');
            $table->foreignUuid('sent_by')->constrained('users')->restrictOnDelete();
            $table->string('sent_to_email');
            $table->timestampTz('sent_at');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_up_letters');
    }
};
