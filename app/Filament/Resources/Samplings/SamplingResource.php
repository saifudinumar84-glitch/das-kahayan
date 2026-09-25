<?php

namespace App\Filament\Resources\Samplings;

use App\Filament\Resources\Common\RelationManagers\AttachmentsRelationManager;
use App\Filament\Resources\Common\RelationManagers\StatusHistoriesRelationManager;
use App\Filament\Resources\Samplings\Pages\CreateSampling;
use App\Filament\Resources\Samplings\Pages\EditSampling;
use App\Filament\Resources\Samplings\Pages\ListSamplings;
use App\Filament\Resources\Samplings\RelationManagers\TestResultsRelationManager;
use App\Filament\Resources\Samplings\Schemas\SamplingForm;
use App\Filament\Resources\Samplings\Tables\SamplingsTable;
use App\Models\Sampling;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SamplingResource extends Resource
{
    protected static ?string $model = Sampling::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|UnitEnum|null $navigationGroup = 'Pengawasan Pangan';

    protected static ?string $modelLabel = 'Sampling Produk';

    protected static ?string $pluralModelLabel = 'Sampling & Pengujian';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return SamplingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SamplingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TestResultsRelationManager::class,
            AttachmentsRelationManager::class,
            StatusHistoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSamplings::route('/'),
            'create' => CreateSampling::route('/create'),
            'edit' => EditSampling::route('/{record}/edit'),
        ];
    }
}
