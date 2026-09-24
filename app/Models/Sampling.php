<?php

namespace App\Models;

use App\Enums\PublicationStatus;
use App\Enums\SamplingConclusion;
use App\Enums\SamplingStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Sampling extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sampling_number',
        'plan_id',
        'inspector_id',
        'sampling_date',
        'product_name',
        'brand',
        'food_type_id',
        'sampling_location',
        'sampling_facility_id',
        'purchase_price',
        'geo_latitude',
        'geo_longitude',
        'geo_accuracy_m',
        'geo_captured_at',
        'test_date',
        'status',
        'conclusion',
        'conclusion_notes',
        'recommendation',
        'publication_status',
        'published_at',
        'published_by',
        'search_vector',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sampling_date' => 'date',
            'test_date' => 'date',
            'geo_captured_at' => 'datetime',
            'published_at' => 'datetime',
            'purchase_price' => 'decimal:2',
            'geo_latitude' => 'decimal:8',
            'geo_longitude' => 'decimal:8',
            'geo_accuracy_m' => 'decimal:2',
            'status' => SamplingStatus::class,
            'conclusion' => SamplingConclusion::class,
            'publication_status' => PublicationStatus::class,
        ];
    }

    /**
     * The supervision plan this sampling belongs to.
     *
     * @return BelongsTo<SupervisionPlan, $this>
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(SupervisionPlan::class, 'plan_id');
    }

    /**
     * The inspector who conducted the sampling.
     *
     * @return BelongsTo<User, $this>
     */
    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    /**
     * The food type of the sampled product.
     *
     * @return BelongsTo<FoodType, $this>
     */
    public function foodType(): BelongsTo
    {
        return $this->belongsTo(FoodType::class, 'food_type_id');
    }

    /**
     * The facility where sampling occurred (if applicable).
     *
     * @return BelongsTo<Facility, $this>
     */
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'sampling_facility_id');
    }

    /**
     * The user who published this sampling result.
     *
     * @return BelongsTo<User, $this>
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    /**
     * Laboratory test results for this sampling.
     *
     * @return HasMany<TestResult, $this>
     */
    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class, 'sampling_id');
    }

    /**
     * Polymorphic attachments (photos, proof files).
     *
     * @return MorphMany<Attachment, $this>
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * Polymorphic status change history.
     *
     * @return MorphMany<StatusHistory, $this>
     */
    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }
}
