<?php

namespace App\Filament\Resources\InspectionRequirements;

use App\Filament\Resources\InspectionRequirements\Pages\CreateInspectionRequirement;
use App\Filament\Resources\InspectionRequirements\Pages\EditInspectionRequirement;
use App\Filament\Resources\InspectionRequirements\Pages\ListInspectionRequirements;
use App\Filament\Resources\InspectionRequirements\Schemas\InspectionRequirementForm;
use App\Filament\Resources\InspectionRequirements\Tables\InspectionRequirementsTable;
use App\Models\InspectionRequirement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InspectionRequirementResource extends Resource
{
    protected static ?string $model = InspectionRequirement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?string $modelLabel = 'Persyaratan CPPOB/CPerPOB';

    protected static ?string $pluralModelLabel = 'Persyaratan Standar';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return InspectionRequirementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InspectionRequirementsTable::configure($table);
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
            'index' => ListInspectionRequirements::route('/'),
            'create' => CreateInspectionRequirement::route('/create'),
            'edit' => EditInspectionRequirement::route('/{record}/edit'),
        ];
    }
}
