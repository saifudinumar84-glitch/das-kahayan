<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SupervisionPlanType: string implements HasColor, HasLabel
{
    case Sampling = 'sampling';
    case Inspection = 'inspection';
    case Both = 'both';

    public function getLabel(): string
    {
        return match ($this) {
            self::Sampling => 'Sampling Produk',
            self::Inspection => 'Pemeriksaan Sarana',
            self::Both => 'Sampling & Pemeriksaan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Sampling => 'info',
            self::Inspection => 'warning',
            self::Both => 'primary',
        };
    }
}
