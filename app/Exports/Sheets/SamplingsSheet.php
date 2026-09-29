<?php

namespace App\Exports\Sheets;

use App\Models\Sampling;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SamplingsSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function __construct(
        protected ?string $startDate = null,
        protected ?string $endDate = null,
        protected ?string $regency = null,
        protected ?string $conclusion = null,
    ) {}

    public function title(): string
    {
        return 'Data Sampling & Pengujian';
    }

    public function collection(): Collection
    {
        $query = Sampling::with(['foodType.category', 'inspector', 'testResults.testParameter'])
            ->latest('sampling_date');

        if ($this->startDate) {
            $query->whereDate('sampling_date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('sampling_date', '<=', $this->endDate);
        }
        if ($this->regency) {
            $query->where('sampling_location', 'like', "%{$this->regency}%");
        }
        if ($this->conclusion) {
            $query->where('conclusion', $this->conclusion);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Sampling',
            'Tanggal Sampling',
            'Nama Produk Pangan',
            'Merk / Dagang',
            'Kategori Pangan',
            'Jenis Pangan',
            'Lokasi Pengambilan',
            'Tanggal Uji',
            'Kesimpulan Uji',
            'Catatan Pengujian',
            'Status',
            'Petugas Pengambil',
        ];
    }

    /**
     * @param  Sampling  $sampling
     */
    public function map($sampling): array
    {
        static $row = 0;
        $row++;

        return [
            $row,
            $sampling->sampling_number,
            $sampling->sampling_date?->format('d/m/Y') ?? '-',
            $sampling->product_name,
            $sampling->brand ?? '-',
            $sampling->foodType?->category?->name ?? '-',
            $sampling->foodType?->name ?? '-',
            $sampling->sampling_location ?? '-',
            $sampling->test_date?->format('d/m/Y') ?? '-',
            $sampling->conclusion?->getLabel() ?? 'Belum Uji',
            $sampling->conclusion_notes ?? '-',
            $sampling->status?->getLabel() ?? '-',
            $sampling->inspector?->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
            ],
        ];
    }
}
