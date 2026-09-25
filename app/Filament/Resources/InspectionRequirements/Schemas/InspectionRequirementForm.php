<?php

namespace App\Filament\Resources\InspectionRequirements\Schemas;

use App\Enums\InspectionStandard;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InspectionRequirementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Persyaratan Standar Pemeriksaan')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('standard')
                                ->label('Standar Pemeriksaan')
                                ->options(InspectionStandard::class)
                                ->required(),
                            TextInput::make('code')
                                ->label('Kode Klausul / Butir')
                                ->required()
                                ->maxLength(50),
                            Textarea::make('description')
                                ->label('Deskripsi / Klausul Persyaratan')
                                ->required()
                                ->columnSpanFull(),
                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->default(true)
                                ->required(),
                        ]),
                    ]),
            ]);
    }
}
