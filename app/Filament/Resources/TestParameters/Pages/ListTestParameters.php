<?php

namespace App\Filament\Resources\TestParameters\Pages;

use App\Filament\Resources\TestParameters\TestParameterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTestParameters extends ListRecords
{
    protected static string $resource = TestParameterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
