<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ComplianceStatus: string implements HasColor, HasLabel
{
    case Compliant = 'compliant';
    case NonCompliant = 'non_compliant';

    public function getLabel(): string
    {
        return match ($this) {
            self::Compliant => 'Memenuhi Syarat (MS)',
            self::NonCompliant => 'Tidak Memenuhi Syarat (TMS)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Compliant => 'success',
            self::NonCompliant => 'danger',
        };
    }
}
