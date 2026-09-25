<?php

namespace App\Filament\Resources\InspectionRequirements\Pages;

use App\Filament\Resources\InspectionRequirements\InspectionRequirementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInspectionRequirement extends EditRecord
{
    protected static string $resource = InspectionRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
