<?php

namespace App\Filament\Resources\FoodCategories;

use App\Filament\Resources\FoodCategories\Pages\CreateFoodCategory;
use App\Filament\Resources\FoodCategories\Pages\EditFoodCategory;
use App\Filament\Resources\FoodCategories\Pages\ListFoodCategories;
use App\Filament\Resources\FoodCategories\Schemas\FoodCategoryForm;
use App\Filament\Resources\FoodCategories\Tables\FoodCategoriesTable;
use App\Models\FoodCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FoodCategoryResource extends Resource
{
    protected static ?string $model = FoodCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?string $modelLabel = 'Kategori Pangan';

    protected static ?string $pluralModelLabel = 'Kategori Pangan';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return FoodCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FoodCategoriesTable::configure($table);
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
            'index' => ListFoodCategories::route('/'),
            'create' => CreateFoodCategory::route('/create'),
            'edit' => EditFoodCategory::route('/{record}/edit'),
        ];
    }
}
