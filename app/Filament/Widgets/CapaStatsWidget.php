<?php

namespace App\Filament\Widgets;

use App\Enums\CapaClosureStatus;
use App\Enums\CapaSubmissionStatus;
use App\Models\CapaClosure;
use App\Models\CapaSubmission;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CapaStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $submitted = CapaSubmission::where('status', CapaSubmissionStatus::Submitted)->count();
        $accepted = CapaSubmission::where('status', CapaSubmissionStatus::Accepted)->count();
        $rejected = CapaSubmission::where('status', CapaSubmissionStatus::Rejected)->count();
        $closedApproved = CapaClosure::whereIn('status', [
            CapaClosureStatus::Approved,
            CapaClosureStatus::Sent,
        ])->count();

        return [
            Stat::make('CAPA Menunggu Evaluasi', number_format($submitted))
                ->description('Diajukan oleh pelaku usaha')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),
            Stat::make('CAPA Diterima', number_format($accepted))
                ->description('Tindakan perbaikan disetujui')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('CAPA Ditolak / Perbaikan', number_format($rejected))
                ->description('Perlu perbaikan ulang')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
            Stat::make('Closed CAPA Terbit', number_format($closedApproved))
                ->description('Disahkan Kepala Balai')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('primary'),
        ];
    }
}
