<?php

namespace App\Exports;

use App\Models\Sampling;
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

class SamplingsExport implements Export, FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
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
        $query = Sampling::with(['foodType.category', 'inspector', 'testResults'])
            ->latest('sampling_date');

        if ($this->recordIds && count($this->recordIds) > 0) {
            $query->whereIn('id', $this->recordIds);
        }

        if ($this->startDate) {
            $query->whereDate('sampling_date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('sampling_date', '<=', $this->endDate);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Sampling',
            'Tanggal Pengambilan',
            'Nama Produk',
            'Merk / Brand',
            'Kategori Pangan',
            'Jenis Pangan',
            'Lokasi Pengambilan',
            'Harga Beli (Rp)',
            'Tanggal Uji Lab',
            'Kesimpulan Uji',
            'Catatan Uji',
            'Status',
            'Status Publikasi',
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
            $sampling->purchase_price ? number_format($sampling->purchase_price, 0, ',', '.') : '-',
            $sampling->test_date?->format('d/m/Y') ?? '-',
            $sampling->conclusion?->getLabel() ?? 'Belum Uji',
            $sampling->conclusion_notes ?? '-',
            $sampling->status?->getLabel() ?? '-',
            $sampling->publication_status?->getLabel() ?? '-',
            $sampling->inspector?->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '047857']],
            ],
        ];
    }
}
