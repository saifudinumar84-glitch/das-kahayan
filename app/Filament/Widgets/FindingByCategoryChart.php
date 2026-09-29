<?php

namespace App\Filament\Widgets;

use App\Enums\InspectionStandard;
use App\Models\InspectionFinding;
use Filament\Widgets\ChartWidget;

class FindingByCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Temuan Berdasarkan Standar Pengawasan';

    protected static ?int $sort = 6;

    protected function getData(): array
    {
        $cppobCount = InspectionFinding::where('standard', InspectionStandard::Cppob)->count();
        $cperpobCount = InspectionFinding::where('standard', InspectionStandard::Cperpob)->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Temuan',
                    'data' => [$cppobCount, $cperpobCount],
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                    ],
                ],
            ],
            'labels' => [
                InspectionStandard::Cppob->getLabel(),
                InspectionStandard::Cperpob->getLabel(),
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
