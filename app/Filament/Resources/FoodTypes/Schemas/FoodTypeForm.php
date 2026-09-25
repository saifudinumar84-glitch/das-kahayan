<?php

namespace App\Filament\Resources\FoodTypes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FoodTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Jenis Pangan')
                    ->schema([
                        Select::make('food_category_id')
                            ->label('Kategori Pangan')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('name')
                            ->label('Nama Jenis Pangan')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required(),
                    ]),
            ]);
    }
}
