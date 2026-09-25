<?php

namespace App\Filament\Resources\FoodTypes\Pages;

use App\Filament\Resources\FoodTypes\FoodTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFoodType extends EditRecord
{
    protected static string $resource = FoodTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
