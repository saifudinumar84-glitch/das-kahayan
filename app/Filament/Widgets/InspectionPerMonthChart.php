<?php

namespace App\Filament\Widgets;

use App\Models\Inspection;
use Filament\Widgets\ChartWidget;

class InspectionPerMonthChart extends ChartWidget
{
    protected ?string $heading = 'Pelaksanaan Inspeksi Sarana Bulanan';

    protected static ?int $sort = 5;

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(function (int $i) {
            return now()->subMonths($i);
        });

        $labels = $months->map(fn ($m): string => $m->translatedFormat('M Y'))->all();
        $counts = [];

        foreach ($months as $month) {
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            $counts[] = Inspection::whereBetween('inspection_date', [$start, $end])->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Inspeksi',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.7)',
                    'borderColor' => 'rgb(59, 130, 246)',
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
