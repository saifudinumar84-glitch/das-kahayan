<?php

namespace App\Exports\Sheets;

use App\Enums\SamplingConclusion;
use App\Models\CapaClosure;
use App\Models\Facility;
use App\Models\Inspection;
use App\Models\InspectionFinding;
use App\Models\Sampling;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExecutiveSummarySheet implements FromArray, ShouldAutoSize, WithStyles, WithTitle
{
    public function __construct(
        protected ?string $startDate = null,
        protected ?string $endDate = null,
        protected ?string $regency = null,
    ) {}

    public function title(): string
    {
        return 'Ringkasan Eksekutif';
    }

    public function array(): array
    {
        $inspectionQuery = Inspection::query();
        $samplingQuery = Sampling::query();
        $facilityQuery = Facility::query();

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

        $totalInspections = (clone $inspectionQuery)->count();
        $inspectionsMs = (clone $inspectionQuery)->where('conclusion', 'like', '%Memenuhi Syarat%')->orWhere('conclusion', 'MS')->count();
        $inspectionsTms = (clone $inspectionQuery)->where(fn ($q) => $q->where('conclusion', 'like', '%Tidak Memenuhi%')->orWhere('conclusion', 'TMS'))->count();
        $totalFindings = InspectionFinding::whereIn('inspection_id', (clone $inspectionQuery)->pluck('id'))->count();

        $totalSamplings = (clone $samplingQuery)->count();
        $samplingsMs = (clone $samplingQuery)->where('conclusion', SamplingConclusion::Compliant)->count();
        $samplingsTms = (clone $samplingQuery)->where('conclusion', SamplingConclusion::NonCompliant)->count();

        $totalCapaClosed = CapaClosure::whereIn('inspection_id', (clone $inspectionQuery)->pluck('id'))->count();
        $totalFacilities = $facilityQuery->count();

        $periodeText = ($this->startDate && $this->endDate)
            ? "{$this->startDate} s/d {$this->endDate}"
            : 'Seluruh Periode';

        $wilayahText = $this->regency ?: 'Seluruh Wilayah (Kalimantan Tengah)';

        return [
            ['BALAI BESAR PENGAWAS OBAT DAN MAKANAN DI PALANGKA RAY'],
            ['SISTEM INFORMASI KAWAL HASIL PENGAWASAN PANGAN OLAHAN (SI KAHAYAN)'],
            ['LAPORAN REKAPITULASI HASIL PENGAWASAN DAN SAMPLING'],
            [''],
            ['Periode Laporan', $periodeText],
            ['Wilayah Kerja', $wilayahText],
            ['Tanggal Cetak', date('d/m/Y H:i:s')],
            [''],
            ['I. INDIKATOR KINERJA PENGAWASAN SARANA PANGAN', 'JUMLAH', 'PERSENTASE'],
            ['Total Sarana Terdaftar', $totalFacilities, '-'],
            ['Total Pemeriksaan Sarana (Inspeksi)', $totalInspections, '100%'],
            ['Sarana Memenuhi Syarat (MS)', $inspectionsMs, $totalInspections > 0 ? round(($inspectionsMs / $totalInspections) * 100, 1).'%' : '0%'],
            ['Sarana Tidak Memenuhi Syarat (TMS)', $inspectionsTms, $totalInspections > 0 ? round(($inspectionsTms / $totalInspections) * 100, 1).'%' : '0%'],
            ['Total Temuan Ketidaksesuaian', $totalFindings, '-'],
            ['Tindak Lanjut CAPA Selesai (Closed)', $totalCapaClosed, '-'],
            [''],
            ['II. INDIKATOR PENGAWASAN SAMPLING & PENGUJIAN PANGAN', 'JUMLAH', 'PERSENTASE'],
            ['Total Sampel Pangan Diambil', $totalSamplings, '100%'],
            ['Sampel Memenuhi Syarat (MS)', $samplingsMs, $totalSamplings > 0 ? round(($samplingsMs / $totalSamplings) * 100, 1).'%' : '0%'],
            ['Sampel Tidak Memenuhi Syarat (TMS)', $samplingsTms, $totalSamplings > 0 ? round(($samplingsTms / $totalSamplings) * 100, 1).'%' : '0%'],
            ['Sampel Masih Proses Uji', $totalSamplings - ($samplingsMs + $samplingsTms), $totalSamplings > 0 ? round((($totalSamplings - ($samplingsMs + $samplingsTms)) / $totalSamplings) * 100, 1).'%' : '0%'],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '1E3A8A']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],
            2 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2563EB']],
            ],
            3 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '475569']],
            ],
            9 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
            ],
            17 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
            ],
        ];
    }
}
