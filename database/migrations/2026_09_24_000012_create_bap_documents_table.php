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
        Schema::create('bap_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('inspection_id')->unique()->constrained('inspections')->cascadeOnDelete();
            $table->string('document_number')->unique();
            $table->string('file_path');
            $table->string('qr_token')->unique();
            $table->jsonb('content_snapshot');
            $table->timestampTz('generated_at');
            $table->string('sent_to_email')->nullable();
            $table->timestampTz('sent_at')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bap_documents');
    }
};
