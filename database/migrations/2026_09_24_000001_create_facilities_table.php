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
        Schema::create('facilities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('facility_type'); // production, distribution
            $table->string('commodity_type');
            $table->text('address');
            $table->string('regency')->index();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('pic_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('nib')->nullable(); // encrypted
            $table->text('npwp')->nullable(); // encrypted
            $table->string('nie_number')->nullable();
            $table->string('cppob_certificate_number')->nullable();
            $table->date('cppob_certificate_valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->addColumn('tsvector', 'search_vector')->nullable();
            $table->timestampsTz();
        });

        DB::statement('CREATE INDEX facilities_search_vector_idx ON facilities USING gin(search_vector);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
