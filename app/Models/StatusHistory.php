<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StatusHistory extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'statusable_type',
        'statusable_id',
        'old_status',
        'new_status',
        'user_id',
        'notes',
    ];

    /**
     * Get the parent statusable model (sampling, inspection, capa_closure).
     *
     * @return MorphTo<Model, $this>
     */
    public function statusable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * The user who changed the status.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
