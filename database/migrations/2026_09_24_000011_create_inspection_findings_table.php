<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspection_findings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('inspection_id')->constrained('inspections')->cascadeOnDelete();
            $table->foreignUuid('requirement_id')->nullable()->constrained('inspection_requirements')->nullOnDelete();
            $table->string('standard'); // cppob, cperpob
            $table->text('description');
            $table->text('recommendation')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status')->default('open'); // open, closed
            $table->timestampTz('closed_at')->nullable();
            $table->foreignUuid('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampsTz();
        });

        DB::statement("CREATE INDEX inspection_findings_open_idx ON inspection_findings (status) WHERE status = 'open';");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_findings');
    }
};
