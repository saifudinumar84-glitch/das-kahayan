<?php

namespace App\Filament\Widgets;

use App\Enums\SamplingConclusion;
use App\Models\Sampling;
use Filament\Widgets\ChartWidget;

class SamplingPerMonthChart extends ChartWidget
{
    protected ?string $heading = 'Tren Pengujian Sampel Bulanan';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(function (int $i) {
            return now()->subMonths($i);
        });

        $labels = $months->map(fn ($m): string => $m->translatedFormat('M Y'))->all();
        $msData = [];
        $tmsData = [];

        foreach ($months as $month) {
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            $msData[] = Sampling::where('conclusion', SamplingConclusion::Compliant)
                ->whereBetween('sampling_date', [$start, $end])
                ->count();

            $tmsData[] = Sampling::where('conclusion', SamplingConclusion::NonCompliant)
                ->whereBetween('sampling_date', [$start, $end])
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Memenuhi Syarat (MS)',
                    'data' => $msData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.7)',
                    'borderColor' => 'rgb(16, 185, 129)',
                ],
                [
                    'label' => 'Tidak Memenuhi Syarat (TMS)',
                    'data' => $tmsData,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.7)',
                    'borderColor' => 'rgb(239, 68, 68)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
