<?php

namespace App\Filament\Widgets;

use App\Enums\FindingStatus;
use App\Models\Inspection;
use App\Models\InspectionFinding;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InspectionStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalInspections = Inspection::count();
        $openFindings = InspectionFinding::where('status', FindingStatus::Open)->count();
        $closedFindings = InspectionFinding::where('status', FindingStatus::Closed)->count();
        $overdueFindings = InspectionFinding::where('status', FindingStatus::Open)
            ->where('due_date', '<', now())
            ->count();

        return [
            Stat::make('Total Inspeksi Sarana', number_format($totalInspections))
                ->description('Total pelaksanaan audit sarana')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('primary'),
            Stat::make('Temuan Terbuka (Open)', number_format($openFindings))
                ->description('Memerlukan tindak lanjut CAPA')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('warning'),
            Stat::make('Temuan Selesai (Closed)', number_format($closedFindings))
                ->description('Perbaikan telah diverifikasi')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Temuan Melewati Batas Waktu', number_format($overdueFindings))
                ->description('Jatuh tempo terlampaui')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
        ];
    }
}
