<?php

namespace App\Exports;

use App\Enums\PublicationStatus;
use App\Models\Inspection;
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

class PublicSupervisionExport implements Export, FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    public function __construct(
        protected ?string $type = 'all', // all, inspection, sampling
        protected ?string $search = null,
        protected ?string $regency = null,
        protected ?string $conclusion = null,
    ) {}

    public function collection(): Collection
    {
        $items = collect();

        if (in_array($this->type, ['all', 'inspection'], true)) {
            $inspectionQuery = Inspection::with('facility')
                ->where('publication_status', PublicationStatus::Published)
                ->latest('inspection_date');

            if ($this->search) {
                $inspectionQuery->where(function ($q) {
                    $q->where('inspection_number', 'ilike', "%{$this->search}%")
                        ->orWhereHas('facility', fn ($fq) => $fq->where('name', 'ilike', "%{$this->search}%"));
                });
            }

            if ($this->regency) {
                $inspectionQuery->whereHas('facility', fn ($q) => $q->where('regency', $this->regency));
            }

            if ($this->conclusion) {
                $inspectionQuery->where('conclusion', 'like', "%{$this->conclusion}%");
            }

            foreach ($inspectionQuery->get() as $insp) {
                $items->push([
                    'type' => 'Inspeksi Sarana',
                    'date' => $insp->inspection_date?->format('d/m/Y') ?? '-',
                    'subject' => $insp->facility?->name ?? '-',
                    'category' => $insp->facility?->facility_type === 'production' ? 'Produksi Pangan' : 'Distribusi Pangan',
                    'location' => $insp->facility?->regency ?? '-',
                    'grade' => $insp->grade ?? '-',
                    'conclusion' => $insp->conclusion ?? 'Memenuhi Ketentuan',
                ]);
            }
        }

        if (in_array($this->type, ['all', 'sampling'], true)) {
            $samplingQuery = Sampling::with(['foodType.category'])
                ->where('publication_status', PublicationStatus::Published)
                ->latest('sampling_date');

            if ($this->search) {
                $samplingQuery->where(function ($q) {
                    $q->where('product_name', 'ilike', "%{$this->search}%")
                        ->orWhere('brand', 'ilike', "%{$this->search}%")
                        ->orWhere('sampling_number', 'ilike', "%{$this->search}%");
                });
            }

            if ($this->regency) {
                $samplingQuery->where('sampling_location', 'ilike', "%{$this->regency}%");
            }

            if ($this->conclusion) {
                $samplingQuery->where('conclusion', $this->conclusion);
            }

            foreach ($samplingQuery->get() as $smp) {
                $items->push([
                    'type' => 'Uji Sampel Pangan',
                    'date' => $smp->sampling_date?->format('d/m/Y') ?? '-',
                    'subject' => $smp->product_name.($smp->brand ? " ({$smp->brand})" : ''),
                    'category' => $smp->foodType?->name ?? 'Pangan Olahan',
                    'location' => $smp->sampling_location ?? '-',
                    'grade' => '-',
                    'conclusion' => $smp->conclusion?->getLabel() ?? 'Belum Uji',
                ]);
            }
        }

        return $items;
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis Pengawasan',
            'Tanggal Pengawasan',
            'Nama Produk / Sarana',
            'Kategori / Jenis Pangan',
            'Kabupaten / Lokasi',
            'Grade Sarana',
            'Kesimpulan Pengawasan',
        ];
    }

    public function map($row): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $row['type'],
            $row['date'],
            $row['subject'],
            $row['category'],
            $row['location'],
            $row['grade'],
            $row['conclusion'],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0284C7']],
            ],
        ];
    }
}
