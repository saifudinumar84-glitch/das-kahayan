<?php

namespace App\Filament\Resources\Samplings\Pages;

use App\Filament\Resources\Samplings\SamplingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSampling extends EditRecord
{
    protected static string $resource = SamplingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
