<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum FacilityType: string implements HasColor, HasLabel
{
    case Production = 'production';
    case Distribution = 'distribution';

    public function getLabel(): string
    {
        return match ($this) {
            self::Production => 'Sarana Produksi',
            self::Distribution => 'Sarana Distribusi',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Production => 'success',
            self::Distribution => 'info',
        };
    }
}
