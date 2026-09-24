<?php

namespace App\Models;

use App\Enums\InspectionStatus;
use App\Enums\PublicationStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Inspection extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'inspection_number',
        'plan_id',
        'facility_id',
        'inspector_id',
        'inspection_date',
        'status',
        'geo_latitude',
        'geo_longitude',
        'geo_accuracy_m',
        'geo_captured_at',
        'grade',
        'conclusion',
        'publication_status',
        'published_at',
        'published_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'inspection_date' => 'date',
            'geo_captured_at' => 'datetime',
            'published_at' => 'datetime',
            'geo_latitude' => 'decimal:8',
            'geo_longitude' => 'decimal:8',
            'geo_accuracy_m' => 'decimal:2',
            'status' => InspectionStatus::class,
            'publication_status' => PublicationStatus::class,
        ];
    }

    /**
     * The supervision plan this inspection belongs to.
     *
     * @return BelongsTo<SupervisionPlan, $this>
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(SupervisionPlan::class, 'plan_id');
    }

    /**
     * The facility being inspected.
     *
     * @return BelongsTo<Facility, $this>
     */
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    /**
     * The inspector who conducted the inspection.
     *
     * @return BelongsTo<User, $this>
     */
    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    /**
     * The user who published this inspection result.
     *
     * @return BelongsTo<User, $this>
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    /**
     * Findings identified during this inspection.
     *
     * @return HasMany<InspectionFinding, $this>
     */
    public function findings(): HasMany
    {
        return $this->hasMany(InspectionFinding::class, 'inspection_id');
    }

    /**
     * Official BAP document issued for this inspection.
     *
     * @return HasOne<BapDocument, $this>
     */
    public function bapDocument(): HasOne
    {
        return $this->hasOne(BapDocument::class, 'inspection_id');
    }

    /**
     * Follow-up letters sent for this inspection.
     *
     * @return HasMany<FollowUpLetter, $this>
     */
    public function followUpLetters(): HasMany
    {
        return $this->hasMany(FollowUpLetter::class, 'inspection_id');
    }

    /**
     * Final Closed CAPA letter for this inspection.
     *
     * @return HasOne<CapaClosure, $this>
     */
    public function capaClosure(): HasOne
    {
        return $this->hasOne(CapaClosure::class, 'inspection_id');
    }

    /**
     * Polymorphic attachments for this inspection.
     *
     * @return MorphMany<Attachment, $this>
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * Polymorphic status histories for this inspection.
     *
     * @return MorphMany<StatusHistory, $this>
     */
    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }
}
