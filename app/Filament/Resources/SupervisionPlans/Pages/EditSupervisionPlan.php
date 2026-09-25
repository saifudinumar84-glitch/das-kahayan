<?php

namespace App\Filament\Resources\SupervisionPlans\Pages;

use App\Filament\Resources\SupervisionPlans\SupervisionPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSupervisionPlan extends EditRecord
{
    protected static string $resource = SupervisionPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
