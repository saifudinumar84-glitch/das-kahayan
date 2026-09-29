<?php

namespace App\Filament\Resources\Samplings\Pages;

use App\Filament\Resources\Samplings\SamplingResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSamplings extends ListRecords
{
    protected static string $resource = SamplingResource::class;

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
