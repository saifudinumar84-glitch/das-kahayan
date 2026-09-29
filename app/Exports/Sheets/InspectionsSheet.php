<?php

namespace App\Exports\Sheets;

use App\Models\Inspection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InspectionsSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function __construct(
        protected ?string $startDate = null,
        protected ?string $endDate = null,
        protected ?string $regency = null,
        protected ?string $conclusion = null,
    ) {}

    public function title(): string
    {
        return 'Data Pemeriksaan Sarana';
    }

    public function collection(): Collection
    {
        $query = Inspection::with(['facility', 'inspector', 'findings', 'capaClosure'])
            ->latest('inspection_date');

        if ($this->startDate) {
            $query->whereDate('inspection_date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('inspection_date', '<=', $this->endDate);
        }
        if ($this->regency) {
            $query->whereHas('facility', fn ($q) => $q->where('regency', $this->regency));
        }
        if ($this->conclusion) {
            $query->where('conclusion', 'like', "%{$this->conclusion}%");
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Pemeriksaan',
            'Tanggal Inspeksi',
            'Nama Sarana',
            'Jenis Sarana',
            'Kabupaten / Kota',
            'Alamat Sarana',
            'Grade',
            'Kesimpulan',
            'Jumlah Temuan',
            'Status Pemeriksaan',
            'Status CAPA',
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

        $capaStatus = 'Tidak Ada Temuan';
        if ($inspection->findings->count() > 0) {
            $capaStatus = $inspection->capaClosure?->status?->getLabel() ?? 'Menunggu Perbaikan';
        }

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
            $capaStatus,
            $inspection->inspector?->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
            ],
        ];
    }
}
