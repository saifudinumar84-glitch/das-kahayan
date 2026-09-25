<?php

namespace App\Filament\Resources\FoodTypes\Pages;

use App\Filament\Resources\FoodTypes\FoodTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFoodType extends CreateRecord
{
    protected static string $resource = FoodTypeResource::class;
}
