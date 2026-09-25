<?php

namespace App\Filament\Resources\InspectionRequirements\Pages;

use App\Filament\Resources\InspectionRequirements\InspectionRequirementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInspectionRequirements extends ListRecords
{
    protected static string $resource = InspectionRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
