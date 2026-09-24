<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasColor, HasLabel
{
    case Admin = 'admin';
    case Inspector = 'inspector';
    case TeamLeader = 'team_leader';
    case Head = 'head';
    case Business = 'business';

    public function getLabel(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Inspector => 'Petugas Layanan (Inspektur)',
            self::TeamLeader => 'Ketua Tim',
            self::Head => 'Kepala Balai',
            self::Business => 'Pelaku Usaha',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Admin => 'danger',
            self::Inspector => 'info',
            self::TeamLeader => 'warning',
            self::Head => 'primary',
            self::Business => 'success',
        };
    }
}
