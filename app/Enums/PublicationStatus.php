<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PublicationStatus: string implements HasColor, HasLabel
{
    case Unpublished = 'unpublished';
    case Published = 'published';

    public function getLabel(): string
    {
        return match ($this) {
            self::Unpublished => 'Belum Dipublikasikan',
            self::Published => 'Dipublikasikan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Unpublished => 'gray',
            self::Published => 'success',
        };
    }
}
