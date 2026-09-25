<?php

namespace App\Filament\Resources\CapaClosures\Pages;

use App\Filament\Resources\CapaClosures\CapaClosureResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCapaClosure extends EditRecord
{
    protected static string $resource = CapaClosureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
