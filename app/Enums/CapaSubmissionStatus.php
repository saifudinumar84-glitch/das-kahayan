<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CapaSubmissionStatus: string implements HasColor, HasLabel
{
    case Submitted = 'submitted';
    case Accepted = 'accepted';
    case Rejected = 'rejected';

    public function getLabel(): string
    {
        return match ($this) {
            self::Submitted => 'Diajukan',
            self::Accepted => 'Diterima',
            self::Rejected => 'Ditolak / Perbaikan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Submitted => 'info',
            self::Accepted => 'success',
            self::Rejected => 'danger',
        };
    }
}
