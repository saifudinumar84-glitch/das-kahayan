<?php

namespace App\Exports;

use App\Exports\Sheets\CapaClosuresSheet;
use App\Exports\Sheets\ExecutiveSummarySheet;
use App\Exports\Sheets\InspectionsSheet;
use App\Exports\Sheets\SamplingsSheet;
use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SupervisionReportExport implements Export, WithMultipleSheets
{
    use Exportable;

    public function __construct(
        protected ?string $startDate = null,
        protected ?string $endDate = null,
        protected ?string $regency = null,
        protected ?string $conclusion = null,
    ) {}

    public function sheets(): array
    {
        return [
            new ExecutiveSummarySheet($this->startDate, $this->endDate, $this->regency),
            new InspectionsSheet($this->startDate, $this->endDate, $this->regency, $this->conclusion),
            new SamplingsSheet($this->startDate, $this->endDate, $this->regency, $this->conclusion),
            new CapaClosuresSheet($this->startDate, $this->endDate, $this->regency),
        ];
    }
}
