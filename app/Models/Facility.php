<?php

namespace App\Models;

use App\Enums\FacilityType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'facility_type',
        'commodity_type',
        'address',
        'regency',
        'latitude',
        'longitude',
        'pic_name',
        'phone',
        'email',
        'nib',
        'npwp',
        'nie_number',
        'cppob_certificate_number',
        'cppob_certificate_valid_until',
        'is_active',
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
            'facility_type' => FacilityType::class,
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'cppob_certificate_valid_until' => 'date',
            'is_active' => 'boolean',
            'nib' => 'encrypted',
            'npwp' => 'encrypted',
        ];
    }

    /**
     * Users associated with this facility.
     *
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'facility_users', 'facility_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Inspections conducted at this facility.
     *
     * @return HasMany<Inspection, $this>
     */
    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class, 'facility_id');
    }

    /**
     * Samplings conducted at this facility.
     *
     * @return HasMany<Sampling, $this>
     */
    public function samplings(): HasMany
    {
        return $this->hasMany(Sampling::class, 'sampling_facility_id');
    }
}
