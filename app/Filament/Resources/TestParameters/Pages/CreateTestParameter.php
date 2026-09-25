<?php

namespace App\Filament\Resources\TestParameters\Pages;

use App\Filament\Resources\TestParameters\TestParameterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTestParameter extends CreateRecord
{
    protected static string $resource = TestParameterResource::class;
}
