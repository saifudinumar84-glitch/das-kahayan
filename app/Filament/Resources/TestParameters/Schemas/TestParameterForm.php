<?php

namespace App\Filament\Resources\TestParameters\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestParameterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Parameter Uji Laboratorium')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('code')
                                ->label('Kode Parameter')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(50),
                            TextInput::make('name')
                                ->label('Nama Parameter Uji')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('result_unit')
                                ->label('Satuan Hasil (Unit)')
                                ->placeholder('misal: mg/kg, CFU/g, %')
                                ->maxLength(50),
                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->default(true)
                                ->required(),
                        ]),
                    ]),
            ]);
    }
}
