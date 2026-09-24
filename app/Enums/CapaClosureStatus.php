<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CapaClosureStatus: string implements HasColor, HasLabel
{
    case PendingVerification = 'pending_verification';
    case PendingApproval = 'pending_approval';
    case Approved = 'approved';
    case Sent = 'sent';
    case Returned = 'returned';

    public function getLabel(): string
    {
        return match ($this) {
            self::PendingVerification => 'Menunggu Verifikasi (Ketua Tim)',
            self::PendingApproval => 'Menunggu Pengesahan (Kepala Balai)',
            self::Approved => 'Disahkan',
            self::Sent => 'Terkirim ke Pelaku Usaha',
            self::Returned => 'Dikembalikan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PendingVerification => 'warning',
            self::PendingApproval => 'primary',
            self::Approved => 'info',
            self::Sent => 'success',
            self::Returned => 'danger',
        };
    }
}
