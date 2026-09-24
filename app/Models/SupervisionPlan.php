<?php

namespace App\Models;

use App\Enums\SupervisionPlanStatus;
use App\Enums\SupervisionPlanType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupervisionPlan extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'plan_type',
        'period_start',
        'period_end',
        'status',
        'created_by',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'plan_type' => SupervisionPlanType::class,
            'period_start' => 'date',
            'period_end' => 'date',
            'status' => SupervisionPlanStatus::class,
        ];
    }

    /**
     * The team leader who created the plan.
     *
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Samplings scheduled under this plan.
     *
     * @return HasMany<Sampling, $this>
     */
    public function samplings(): HasMany
    {
        return $this->hasMany(Sampling::class, 'plan_id');
    }

    /**
     * Inspections scheduled under this plan.
     *
     * @return HasMany<Inspection, $this>
     */
    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class, 'plan_id');
    }
}
