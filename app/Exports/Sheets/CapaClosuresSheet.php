<?php

namespace App\Exports\Sheets;

use App\Models\CapaClosure;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CapaClosuresSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function __construct(
        protected ?string $startDate = null,
        protected ?string $endDate = null,
        protected ?string $regency = null,
    ) {}

    public function title(): string
    {
        return 'Status Tindak Lanjut CAPA';
    }

    public function collection(): Collection
    {
        $query = CapaClosure::with(['inspection.facility', 'verifier', 'approver'])
            ->latest('created_at');

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }
        if ($this->regency) {
            $query->whereHas('inspection.facility', fn ($q) => $q->where('regency', $this->regency));
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Surat Closed CAPA',
            'No. Pemeriksaan Terkait',
            'Nama Sarana',
            'Kabupaten / Kota',
            'Status Penutupan',
            'Diverifikasi Oleh (Ketua Tim)',
            'Tanggal Verifikasi',
            'Disetujui Oleh (Kepala Balai)',
            'Tanggal Disetujui',
            'Tanggal Dikirim ke Sarana',
        ];
    }

    /**
     * @param  CapaClosure  $closure
     */
    public function map($closure): array
    {
        static $row = 0;
        $row++;

        return [
            $row,
            $closure->letter_number,
            $closure->inspection?->inspection_number ?? '-',
            $closure->inspection?->facility?->name ?? '-',
            $closure->inspection?->facility?->regency ?? '-',
            $closure->status?->getLabel() ?? '-',
            $closure->verifier?->name ?? '-',
            $closure->verified_at?->format('d/m/Y H:i') ?? '-',
            $closure->approver?->name ?? '-',
            $closure->approved_at?->format('d/m/Y H:i') ?? '-',
            $closure->sent_at?->format('d/m/Y H:i') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '7C3AED']],
            ],
        ];
    }
}
