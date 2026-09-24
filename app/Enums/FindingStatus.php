<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum FindingStatus: string implements HasColor, HasLabel
{
    case Open = 'open';
    case Closed = 'closed';

    public function getLabel(): string
    {
        return match ($this) {
            self::Open => 'Open (Belum Selesai)',
            self::Closed => 'Closed (Selesai)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Open => 'danger',
            self::Closed => 'success',
        };
    }
}
