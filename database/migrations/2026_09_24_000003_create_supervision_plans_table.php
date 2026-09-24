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
        Schema::create('supervision_plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('plan_type'); // sampling, inspection, both
            $table->date('period_start');
            $table->date('period_end');
            $table->string('status')->default('draft'); // draft, active, completed, cancelled
            $table->foreignUuid('created_by')->constrained('users')->restrictOnDelete();
            $table->text('notes')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervision_plans');
    }
};
