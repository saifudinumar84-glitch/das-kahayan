<?php

namespace App\Filament\Resources\FoodTypes;

use App\Filament\Resources\FoodTypes\Pages\CreateFoodType;
use App\Filament\Resources\FoodTypes\Pages\EditFoodType;
use App\Filament\Resources\FoodTypes\Pages\ListFoodTypes;
use App\Filament\Resources\FoodTypes\Schemas\FoodTypeForm;
use App\Filament\Resources\FoodTypes\Tables\FoodTypesTable;
use App\Models\FoodType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FoodTypeResource extends Resource
{
    protected static ?string $model = FoodType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCake;

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?string $modelLabel = 'Jenis Pangan';

    protected static ?string $pluralModelLabel = 'Jenis Pangan';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return FoodTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FoodTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFoodTypes::route('/'),
            'create' => CreateFoodType::route('/create'),
            'edit' => EditFoodType::route('/{record}/edit'),
        ];
    }
}
