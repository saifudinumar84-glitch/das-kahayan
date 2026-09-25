<?php

namespace App\Filament\Resources\SupervisionPlans\Pages;

use App\Filament\Resources\SupervisionPlans\SupervisionPlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSupervisionPlans extends ListRecords
{
    protected static string $resource = SupervisionPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
