<?php

namespace App\Models;

use App\Enums\ComplianceStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResult extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sampling_id',
        'test_parameter_id',
        'result_value',
        'unit',
        'requirement_limit',
        'compliance_status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'compliance_status' => ComplianceStatus::class,
        ];
    }

    /**
     * The sampling this test result belongs to.
     *
     * @return BelongsTo<Sampling, $this>
     */
    public function sampling(): BelongsTo
    {
        return $this->belongsTo(Sampling::class, 'sampling_id');
    }

    /**
     * The test parameter tested.
     *
     * @return BelongsTo<TestParameter, $this>
     */
    public function testParameter(): BelongsTo
    {
        return $this->belongsTo(TestParameter::class, 'test_parameter_id');
    }
}
