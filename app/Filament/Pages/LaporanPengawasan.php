<?php

namespace App\Filament\Pages;

use App\Enums\SamplingConclusion;
use App\Models\CapaClosure;
use App\Models\Inspection;
use App\Models\InspectionFinding;
use App\Models\Sampling;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class LaporanPengawasan extends Page
{
    protected static string $routePath = 'laporan-pengawasan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;

    protected static ?string $navigationLabel = 'Laporan Pengawasan';

    protected static ?string $title = 'Laporan Rekapitulasi Pengawasan';

    protected static ?int $navigationSort = 20;

    protected string $view = 'filament.pages.laporan-pengawasan';

    public ?string $startDate = null;

    public ?string $endDate = null;

    public ?string $regency = '';

    public ?string $conclusion = '';

    public function mount(): void
    {
        $this->startDate = now()->startOfYear()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportExcel')
                ->label('Ekspor Excel (.xlsx)')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn (): string => route('export.executive.excel', [
                    'start_date' => $this->startDate,
                    'end_date' => $this->endDate,
                    'regency' => $this->regency,
                    'conclusion' => $this->conclusion,
                ]), shouldOpenInNewTab: true),

            Action::make('exportPdf')
                ->label('Ekspor PDF (.pdf)')
                ->icon('heroicon-o-printer')
                ->color('danger')
                ->url(fn (): string => route('export.executive.pdf', [
                    'start_date' => $this->startDate,
                    'end_date' => $this->endDate,
                    'regency' => $this->regency,
                    'conclusion' => $this->conclusion,
                ]), shouldOpenInNewTab: true),
        ];
    }

    public function getReportDataProperty(): array
    {
        $inspectionQuery = Inspection::with(['facility', 'inspector', 'findings', 'capaClosure'])
            ->latest('inspection_date');

        $samplingQuery = Sampling::with(['foodType.category', 'inspector', 'testResults'])
            ->latest('sampling_date');

        if ($this->startDate) {
            $inspectionQuery->whereDate('inspection_date', '>=', $this->startDate);
            $samplingQuery->whereDate('sampling_date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $inspectionQuery->whereDate('inspection_date', '<=', $this->endDate);
            $samplingQuery->whereDate('sampling_date', '<=', $this->endDate);
        }

        if ($this->regency) {
            $inspectionQuery->whereHas('facility', fn ($q) => $q->where('regency', $this->regency));
            $samplingQuery->where('sampling_location', 'like', "%{$this->regency}%");
        }

        if ($this->conclusion) {
            $inspectionQuery->where('conclusion', 'like', "%{$this->conclusion}%");
            $samplingQuery->where('conclusion', $this->conclusion);
        }

        $inspections = $inspectionQuery->take(20)->get();
        $samplings = $samplingQuery->take(20)->get();

        $totalInspections = (clone $inspectionQuery)->count();
        $inspectionsMs = (clone $inspectionQuery)->where(fn ($q) => $q->where('conclusion', 'like', '%Memenuhi Syarat%')->orWhere('conclusion', 'MS'))->count();
        $inspectionsTms = (clone $inspectionQuery)->where(fn ($q) => $q->where('conclusion', 'like', '%Tidak Memenuhi%')->orWhere('conclusion', 'TMS'))->count();

        $totalSamplings = (clone $samplingQuery)->count();
        $samplingsMs = (clone $samplingQuery)->where('conclusion', SamplingConclusion::Compliant)->count();
        $samplingsTms = (clone $samplingQuery)->where('conclusion', SamplingConclusion::NonCompliant)->count();

        $totalFindings = InspectionFinding::whereIn('inspection_id', (clone $inspectionQuery)->pluck('id'))->count();
        $totalCapaClosed = CapaClosure::whereIn('inspection_id', (clone $inspectionQuery)->pluck('id'))->count();

        return [
            'inspections' => $inspections,
            'samplings' => $samplings,
            'stats' => [
                'total_inspections' => $totalInspections,
                'inspections_ms' => $inspectionsMs,
                'inspections_tms' => $inspectionsTms,
                'total_samplings' => $totalSamplings,
                'samplings_ms' => $samplingsMs,
                'samplings_tms' => $samplingsTms,
                'total_findings' => $totalFindings,
                'total_capa_closed' => $totalCapaClosed,
            ],
        ];
    }
}
