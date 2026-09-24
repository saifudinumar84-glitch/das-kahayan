<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InspectionStandard: string implements HasColor, HasLabel
{
    case Cppob = 'cppob';
    case Cperpob = 'cperpob';

    public function getLabel(): string
    {
        return match ($this) {
            self::Cppob => 'CPPOB (Produksi)',
            self::Cperpob => 'CPerPOB (Peredaran)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Cppob => 'info',
            self::Cperpob => 'warning',
        };
    }
}
