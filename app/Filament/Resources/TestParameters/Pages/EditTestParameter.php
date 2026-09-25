<?php

namespace App\Filament\Resources\TestParameters\Pages;

use App\Filament\Resources\TestParameters\TestParameterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTestParameter extends EditRecord
{
    protected static string $resource = TestParameterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
