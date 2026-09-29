<?php

namespace App\Exports;

use App\Models\InspectionFinding;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FindingsCapaExport implements Export, FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    /**
     * @param  array<string>|null  $facilityIds
     */
    public function __construct(
        protected ?array $facilityIds = null,
        protected ?string $status = null,
    ) {}

    public function collection(): Collection
    {
        $query = InspectionFinding::with(['inspection.facility', 'requirement', 'capaSubmissions'])
            ->latest('created_at');

        if ($this->facilityIds && count($this->facilityIds) > 0) {
            $query->whereHas('inspection', fn ($q) => $q->whereIn('facility_id', $this->facilityIds));
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Pemeriksaan',
            'Sarana',
            'Standar Inspeksi',
            'Pasal / Klausul Persyaratan',
            'Uraian Temuan Ketidaksesuaian',
            'Rekomendasi Perbaikan',
            'Batas Waktu Perbaikan',
            'Status CAPA',
            'Jumlah Bukti Perbaikan Dikirim',
            'Tanggal Penutupan Temuan',
        ];
    }

    /**
     * @param  InspectionFinding  $finding
     */
    public function map($finding): array
    {
        static $row = 0;
        $row++;

        return [
            $row,
            $finding->inspection?->inspection_number ?? '-',
            $finding->inspection?->facility?->name ?? '-',
            $finding->standard?->value ?? '-',
            $finding->requirement?->clause_title ?? $finding->requirement?->code ?? '-',
            $finding->description,
            $finding->recommendation ?? '-',
            $finding->due_date?->format('d/m/Y') ?? '-',
            $finding->status?->getLabel() ?? '-',
            $finding->capaSubmissions->count(),
            $finding->closed_at?->format('d/m/Y H:i') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '6B21A8']],
            ],
        ];
    }
}
