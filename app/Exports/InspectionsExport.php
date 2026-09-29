<?php

namespace App\Exports;

use App\Models\Inspection;
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

class InspectionsExport implements Export, FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    /**
     * @param  array<string>|null  $recordIds
     */
    public function __construct(
        protected ?array $recordIds = null,
        protected ?string $startDate = null,
        protected ?string $endDate = null,
    ) {}

    public function collection(): Collection
    {
        $query = Inspection::with(['facility', 'inspector', 'findings', 'capaClosure'])
            ->latest('inspection_date');

        if ($this->recordIds && count($this->recordIds) > 0) {
            $query->whereIn('id', $this->recordIds);
        }

        if ($this->startDate) {
            $query->whereDate('inspection_date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('inspection_date', '<=', $this->endDate);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Pemeriksaan',
            'Tanggal Pemeriksaan',
            'Nama Sarana',
            'Jenis Sarana',
            'Kabupaten / Kota',
            'Alamat Sarana',
            'Grade Sarana',
            'Kesimpulan',
            'Jumlah Temuan',
            'Status Pemeriksaan',
            'Status Publikasi',
            'Inspektur Pemeriksa',
        ];
    }

    /**
     * @param  Inspection  $inspection
     */
    public function map($inspection): array
    {
        static $row = 0;
        $row++;

        return [
            $row,
            $inspection->inspection_number,
            $inspection->inspection_date?->format('d/m/Y') ?? '-',
            $inspection->facility?->name ?? '-',
            $inspection->facility?->facility_type === 'production' ? 'Produksi' : 'Distribusi',
            $inspection->facility?->regency ?? '-',
            $inspection->facility?->address ?? '-',
            $inspection->grade ?? '-',
            $inspection->conclusion ?? '-',
            $inspection->findings->count(),
            $inspection->status?->getLabel() ?? '-',
            $inspection->publication_status?->getLabel() ?? '-',
            $inspection->inspector?->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E40AF']],
            ],
        ];
    }
}
