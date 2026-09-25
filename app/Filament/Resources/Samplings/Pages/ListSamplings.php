<?php

namespace App\Filament\Resources\Samplings\Pages;

use App\Filament\Resources\Samplings\SamplingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSamplings extends ListRecords
{
    protected static string $resource = SamplingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
