<?php

namespace App\Models;

use App\Enums\CapaClosureStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CapaClosure extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'inspection_id',
        'letter_number',
        'status',
        'verified_by',
        'verified_at',
        'approved_by',
        'approved_at',
        'file_path',
        'sent_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => CapaClosureStatus::class,
            'verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'sent_at' => 'datetime',
        ];
    }

    /**
     * The inspection this closed CAPA letter is for.
     *
     * @return BelongsTo<Inspection, $this>
     */
    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class, 'inspection_id');
    }

    /**
     * The team leader who verified this closed CAPA.
     *
     * @return BelongsTo<User, $this>
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * The head of office (Kepala Balai) who approved this closed CAPA.
     *
     * @return BelongsTo<User, $this>
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Polymorphic status histories for this closure letter.
     *
     * @return MorphMany<StatusHistory, $this>
     */
    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }
}
