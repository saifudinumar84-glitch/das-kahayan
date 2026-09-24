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
        Schema::create('attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('attachable');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('mime')->nullable();
            $table->unsignedInteger('size_kb')->nullable();
            $table->string('caption')->nullable();
            $table->foreignUuid('uploaded_by')->constrained('users')->restrictOnDelete();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
