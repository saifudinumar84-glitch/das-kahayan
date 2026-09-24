<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SamplingStatus: string implements HasColor, HasLabel
{
    case Planned = 'planned';
    case Sampled = 'sampled';
    case InTesting = 'in_testing';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Planned => 'Direncanakan',
            self::Sampled => 'Disampling',
            self::InTesting => 'Dalam Pengujian',
            self::Completed => 'Selesai',
            self::Cancelled => 'Dibatalkan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Planned => 'gray',
            self::Sampled => 'info',
            self::InTesting => 'warning',
            self::Completed => 'success',
            self::Cancelled => 'danger',
        };
    }
}
