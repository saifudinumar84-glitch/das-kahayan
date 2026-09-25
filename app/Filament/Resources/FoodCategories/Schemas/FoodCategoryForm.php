<?php

namespace App\Filament\Resources\FoodCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FoodCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kategori Pangan')
                    ->schema([
                        TextInput::make('code')
                            ->label('Kode Kategori')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),
                        TextInput::make('name')
                            ->label('Nama Kategori Pangan')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
