<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InspectionStatus: string implements HasColor, HasLabel
{
    case Planned = 'planned';
    case InProgress = 'in_progress';
    case BapIssued = 'bap_issued';
    case AwaitingCapa = 'awaiting_capa';
    case CapaReview = 'capa_review';
    case AwaitingSignature = 'awaiting_signature';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Planned => 'Direncanakan',
            self::InProgress => 'Sedang Berlangsung',
            self::BapIssued => 'BAP Diterbitkan',
            self::AwaitingCapa => 'Menunggu CAPA',
            self::CapaReview => 'Evaluasi CAPA',
            self::AwaitingSignature => 'Menunggu Pengesahan',
            self::Completed => 'Selesai',
            self::Cancelled => 'Dibatalkan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Planned => 'gray',
            self::InProgress => 'info',
            self::BapIssued => 'primary',
            self::AwaitingCapa => 'warning',
            self::CapaReview => 'info',
            self::AwaitingSignature => 'warning',
            self::Completed => 'success',
            self::Cancelled => 'danger',
        };
    }
}
