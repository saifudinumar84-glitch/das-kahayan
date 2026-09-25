<?php

namespace App\Filament\Resources\CapaClosures\Pages;

use App\Filament\Resources\CapaClosures\CapaClosureResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCapaClosures extends ListRecords
{
    protected static string $resource = CapaClosureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
