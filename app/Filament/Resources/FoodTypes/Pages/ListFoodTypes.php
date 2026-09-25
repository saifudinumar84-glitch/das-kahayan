<?php

namespace App\Filament\Resources\FoodTypes\Pages;

use App\Filament\Resources\FoodTypes\FoodTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFoodTypes extends ListRecords
{
    protected static string $resource = FoodTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
