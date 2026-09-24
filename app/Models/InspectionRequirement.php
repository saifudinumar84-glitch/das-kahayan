<?php

namespace App\Models;

use App\Enums\InspectionStandard;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionRequirement extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'standard',
        'code',
        'description',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    /**
     * Inspection findings associated with this requirement violation.
     *
     * @return HasMany<InspectionFinding, $this>
     */
    public function findings(): HasMany
    {
        return $this->hasMany(InspectionFinding::class, 'requirement_id');
    }
}
