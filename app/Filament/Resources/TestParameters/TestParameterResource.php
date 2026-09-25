<?php

namespace App\Filament\Resources\TestParameters;

use App\Filament\Resources\TestParameters\Pages\CreateTestParameter;
use App\Filament\Resources\TestParameters\Pages\EditTestParameter;
use App\Filament\Resources\TestParameters\Pages\ListTestParameters;
use App\Filament\Resources\TestParameters\Schemas\TestParameterForm;
use App\Filament\Resources\TestParameters\Tables\TestParametersTable;
use App\Models\TestParameter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TestParameterResource extends Resource
{
    protected static ?string $model = TestParameter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?string $modelLabel = 'Parameter Uji';

    protected static ?string $pluralModelLabel = 'Parameter Uji';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return TestParameterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestParametersTable::configure($table);
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
            'index' => ListTestParameters::route('/'),
            'create' => CreateTestParameter::route('/create'),
            'edit' => EditTestParameter::route('/{record}/edit'),
        ];
    }
}
