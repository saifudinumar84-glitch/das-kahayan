<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUuids, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'signature_path',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * Determine whether the user can access a specific Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if (! $this->is_active) {
            return false;
        }

        return match ($panel->getId()) {
            'admin' => in_array($this->role, [UserRole::Admin, UserRole::Inspector, UserRole::TeamLeader], true),
            'pimpinan' => in_array($this->role, [UserRole::Head, UserRole::TeamLeader, UserRole::Admin], true),
            'portal' => in_array($this->role, [UserRole::Business, UserRole::Admin], true),
            default => false,
        };
    }

    /**
     * Facilities associated with this business user.
     *
     * @return BelongsToMany<Facility, $this>
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'facility_users', 'user_id', 'facility_id')
            ->withTimestamps();
    }

    /**
     * Supervision plans created by this user (Team Leader).
     *
     * @return HasMany<SupervisionPlan, $this>
     */
    public function supervisionPlans(): HasMany
    {
        return $this->hasMany(SupervisionPlan::class, 'created_by');
    }

    /**
     * Samplings conducted by this inspector.
     *
     * @return HasMany<Sampling, $this>
     */
    public function samplings(): HasMany
    {
        return $this->hasMany(Sampling::class, 'inspector_id');
    }

    /**
     * Inspections conducted by this inspector.
     *
     * @return HasMany<Inspection, $this>
     */
    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class, 'inspector_id');
    }

    /**
     * CAPA submissions made by this user (Business).
     *
     * @return HasMany<CapaSubmission, $this>
     */
    public function capaSubmissions(): HasMany
    {
        return $this->hasMany(CapaSubmission::class, 'submitted_by');
    }

    /**
     * CAPA submissions reviewed by this user (Inspector).
     *
     * @return HasMany<CapaSubmission, $this>
     */
    public function reviewedCapaSubmissions(): HasMany
    {
        return $this->hasMany(CapaSubmission::class, 'reviewed_by');
    }

    /**
     * Closed CAPA verified by this user (Team Leader).
     *
     * @return HasMany<CapaClosure, $this>
     */
    public function verifiedCapaClosures(): HasMany
    {
        return $this->hasMany(CapaClosure::class, 'verified_by');
    }

    /**
     * Closed CAPA approved by this user (Head).
     *
     * @return HasMany<CapaClosure, $this>
     */
    public function approvedCapaClosures(): HasMany
    {
        return $this->hasMany(CapaClosure::class, 'approved_by');
    }

    /**
     * Status histories changed by this user.
     *
     * @return HasMany<StatusHistory, $this>
     */
    public function statusHistories(): HasMany
    {
        return $this->hasMany(StatusHistory::class, 'user_id');
    }

    /**
     * Audit logs performed by this user.
     *
     * @return HasMany<AuditLog, $this>
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'user_id');
    }
}
