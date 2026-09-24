<?php

namespace App\Models;

use App\Enums\FindingStatus;
use App\Enums\InspectionStandard;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class InspectionFinding extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'inspection_id',
        'requirement_id',
        'standard',
        'description',
        'recommendation',
        'due_date',
        'status',
        'closed_at',
        'closed_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'standard' => InspectionStandard::class,
            'status' => FindingStatus::class,
            'due_date' => 'date',
            'closed_at' => 'datetime',
        ];
    }

    /**
     * The inspection this finding belongs to.
     *
     * @return BelongsTo<Inspection, $this>
     */
    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class, 'inspection_id');
    }

    /**
     * The standard requirement violated by this finding.
     *
     * @return BelongsTo<InspectionRequirement, $this>
     */
    public function requirement(): BelongsTo
    {
        return $this->belongsTo(InspectionRequirement::class, 'requirement_id');
    }

    /**
     * The inspector who closed this finding.
     *
     * @return BelongsTo<User, $this>
     */
    public function closer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    /**
     * CAPA submissions answering this finding.
     *
     * @return HasMany<CapaSubmission, $this>
     */
    public function capaSubmissions(): HasMany
    {
        return $this->hasMany(CapaSubmission::class, 'finding_id');
    }

    /**
     * Polymorphic attachments for this finding (e.g. proof photos).
     *
     * @return MorphMany<Attachment, $this>
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
