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
        Schema::create('inspections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('inspection_number')->unique();
            $table->foreignUuid('plan_id')->nullable()->constrained('supervision_plans')->nullOnDelete();
            $table->foreignUuid('facility_id')->constrained('facilities')->cascadeOnDelete();
            $table->foreignUuid('inspector_id')->constrained('users')->restrictOnDelete();
            $table->date('inspection_date');
            $table->string('status')->default('planned'); // planned, in_progress, bap_issued, awaiting_capa, capa_review, awaiting_signature, completed, cancelled
            $table->decimal('geo_latitude', 10, 8)->nullable();
            $table->decimal('geo_longitude', 11, 8)->nullable();
            $table->decimal('geo_accuracy_m', 8, 2)->nullable();
            $table->timestampTz('geo_captured_at')->nullable();
            $table->string('grade')->nullable(); // rating / grade
            $table->text('conclusion')->nullable();
            $table->string('publication_status')->default('unpublished'); // unpublished, published
            $table->timestampTz('published_at')->nullable();
            $table->foreignUuid('published_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampsTz();
        });

        DB::statement("CREATE INDEX inspections_published_idx ON inspections (publication_status) WHERE publication_status = 'published';");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
