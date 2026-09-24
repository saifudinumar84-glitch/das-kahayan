<?php

namespace App\Models;

use App\Enums\CapaSubmissionStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CapaSubmission extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'finding_id',
        'round',
        'corrective_action',
        'preventive_action',
        'submitted_by',
        'submitted_at',
        'status',
        'reviewed_by',
        'reviewed_at',
        'review_notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => CapaSubmissionStatus::class,
            'round' => 'integer',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    /**
     * The inspection finding being addressed.
     *
     * @return BelongsTo<InspectionFinding, $this>
     */
    public function finding(): BelongsTo
    {
        return $this->belongsTo(InspectionFinding::class, 'finding_id');
    }

    /**
     * The business user who submitted this CAPA.
     *
     * @return BelongsTo<User, $this>
     */
    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    /**
     * The inspector who reviewed this CAPA.
     *
     * @return BelongsTo<User, $this>
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Polymorphic supporting attachments (documents/photos).
     *
     * @return MorphMany<Attachment, $this>
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
