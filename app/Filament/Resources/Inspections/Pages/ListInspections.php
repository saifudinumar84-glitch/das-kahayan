<?php

namespace App\Filament\Resources\Inspections\Pages;

use App\Filament\Resources\Inspections\InspectionResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInspections extends ListRecords
{
    protected static string $resource = InspectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('exportExcel')
                ->label('Ekspor Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn (): string => route('export.executive.excel'), shouldOpenInNewTab: true),
            Action::make('exportPdf')
                ->label('Ekspor PDF')
                ->icon('heroicon-o-printer')
                ->color('danger')
                ->url(fn (): string => route('export.executive.pdf'), shouldOpenInNewTab: true),
        ];
    }
}
