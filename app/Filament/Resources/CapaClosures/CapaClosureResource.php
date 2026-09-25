<?php

namespace App\Filament\Resources\CapaClosures;

use App\Filament\Resources\CapaClosures\Pages\CreateCapaClosure;
use App\Filament\Resources\CapaClosures\Pages\EditCapaClosure;
use App\Filament\Resources\CapaClosures\Pages\ListCapaClosures;
use App\Filament\Resources\CapaClosures\Schemas\CapaClosureForm;
use App\Filament\Resources\CapaClosures\Tables\CapaClosuresTable;
use App\Filament\Resources\Common\RelationManagers\StatusHistoriesRelationManager;
use App\Models\CapaClosure;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CapaClosureResource extends Resource
{
    protected static ?string $model = CapaClosure::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    protected static string|UnitEnum|null $navigationGroup = 'Pengawasan Pangan';

    protected static ?string $modelLabel = 'Closed CAPA';

    protected static ?string $pluralModelLabel = 'Pengesahan Closed CAPA';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return CapaClosureForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CapaClosuresTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            StatusHistoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCapaClosures::route('/'),
            'create' => CreateCapaClosure::route('/create'),
            'edit' => EditCapaClosure::route('/{record}/edit'),
        ];
    }
}
