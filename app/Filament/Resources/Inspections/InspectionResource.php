<?php

namespace App\Filament\Resources\Inspections;

use App\Filament\Resources\Common\RelationManagers\AttachmentsRelationManager;
use App\Filament\Resources\Common\RelationManagers\StatusHistoriesRelationManager;
use App\Filament\Resources\Inspections\Pages\CreateInspection;
use App\Filament\Resources\Inspections\Pages\EditInspection;
use App\Filament\Resources\Inspections\Pages\ListInspections;
use App\Filament\Resources\Inspections\RelationManagers\InspectionFindingsRelationManager;
use App\Filament\Resources\Inspections\Schemas\InspectionForm;
use App\Filament\Resources\Inspections\Tables\InspectionsTable;
use App\Models\Inspection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InspectionResource extends Resource
{
    protected static ?string $model = Inspection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static string|UnitEnum|null $navigationGroup = 'Pengawasan Pangan';

    protected static ?string $modelLabel = 'Pemeriksaan Sarana';

    protected static ?string $pluralModelLabel = 'Inspeksi & Temuan';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return InspectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InspectionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InspectionFindingsRelationManager::class,
            AttachmentsRelationManager::class,
            StatusHistoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInspections::route('/'),
            'create' => CreateInspection::route('/create'),
            'edit' => EditInspection::route('/{record}/edit'),
        ];
    }
}
