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
        Schema::create('samplings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('sampling_number')->unique();
            $table->foreignUuid('plan_id')->nullable()->constrained('supervision_plans')->nullOnDelete();
            $table->foreignUuid('inspector_id')->constrained('users')->restrictOnDelete();
            $table->date('sampling_date');
            $table->string('product_name');
            $table->string('brand')->nullable();
            $table->foreignUuid('food_type_id')->constrained('food_types')->restrictOnDelete();
            $table->text('sampling_location');
            $table->foreignUuid('sampling_facility_id')->nullable()->constrained('facilities')->nullOnDelete();
            $table->decimal('purchase_price', 12, 2)->nullable();
            $table->decimal('geo_latitude', 10, 8)->nullable();
            $table->decimal('geo_longitude', 11, 8)->nullable();
            $table->decimal('geo_accuracy_m', 8, 2)->nullable();
            $table->timestampTz('geo_captured_at')->nullable();
            $table->date('test_date')->nullable();
            $table->string('status')->default('planned'); // planned, sampled, in_testing, completed, cancelled
            $table->string('conclusion')->nullable(); // compliant, non_compliant
            $table->text('conclusion_notes')->nullable();
            $table->text('recommendation')->nullable();
            $table->string('publication_status')->default('unpublished'); // unpublished, published
            $table->timestampTz('published_at')->nullable();
            $table->foreignUuid('published_by')->nullable()->constrained('users')->nullOnDelete();
            $table->addColumn('tsvector', 'search_vector')->nullable();
            $table->timestampsTz();
        });

        DB::statement('CREATE INDEX samplings_search_vector_idx ON samplings USING gin(search_vector);');
        DB::statement("CREATE INDEX samplings_published_idx ON samplings (publication_status) WHERE publication_status = 'published';");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samplings');
    }
};
