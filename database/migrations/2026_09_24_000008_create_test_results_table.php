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
        Schema::create('test_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sampling_id')->constrained('samplings')->cascadeOnDelete();
            $table->foreignUuid('test_parameter_id')->constrained('test_parameters')->restrictOnDelete();
            $table->string('result_value');
            $table->string('unit')->nullable();
            $table->string('requirement_limit')->nullable();
            $table->string('compliance_status'); // compliant, non_compliant
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
