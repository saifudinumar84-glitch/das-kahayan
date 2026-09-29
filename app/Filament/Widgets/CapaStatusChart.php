<?php

namespace App\Filament\Widgets;

use App\Enums\CapaSubmissionStatus;
use App\Models\CapaSubmission;
use Filament\Widgets\ChartWidget;

class CapaStatusChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Status Evaluasi CAPA';

    protected static ?int $sort = 7;

    protected function getData(): array
    {
        $submitted = CapaSubmission::where('status', CapaSubmissionStatus::Submitted)->count();
        $accepted = CapaSubmission::where('status', CapaSubmissionStatus::Accepted)->count();
        $rejected = CapaSubmission::where('status', CapaSubmissionStatus::Rejected)->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Dokumen CAPA',
                    'data' => [$submitted, $accepted, $rejected],
                    'backgroundColor' => [
                        'rgba(14, 165, 233, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                    ],
                ],
            ],
            'labels' => [
                CapaSubmissionStatus::Submitted->getLabel(),
                CapaSubmissionStatus::Accepted->getLabel(),
                CapaSubmissionStatus::Rejected->getLabel(),
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
