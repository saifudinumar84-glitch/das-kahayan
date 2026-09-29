<?php

namespace App\Filament\Widgets;

use App\Enums\SamplingConclusion;
use App\Enums\SamplingStatus;
use App\Models\Sampling;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SamplingStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $total = Sampling::count();
        $ms = Sampling::where('conclusion', SamplingConclusion::Compliant)->count();
        $tms = Sampling::where('conclusion', SamplingConclusion::NonCompliant)->count();
        $inProgress = Sampling::whereIn('status', [
            SamplingStatus::Planned,
            SamplingStatus::Sampled,
            SamplingStatus::InTesting,
        ])->count();

        return [
            Stat::make('Total Sampling', number_format($total))
                ->description('Total sampel makanan/minuman')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('primary'),
            Stat::make('Memenuhi Syarat (MS)', number_format($ms))
                ->description($total > 0 ? round(($ms / $total) * 100, 1).'% dari total' : '0%')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Tidak Memenuhi (TMS)', number_format($tms))
                ->description($total > 0 ? round(($tms / $total) * 100, 1).'% dari total' : '0%')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
            Stat::make('Dalam Pengujian', number_format($inProgress))
                ->description('Sampel aktif di lab')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),
        ];
    }
}
