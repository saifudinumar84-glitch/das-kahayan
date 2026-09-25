<?php

namespace App\Filament\Resources\SupervisionPlans;

use App\Filament\Resources\SupervisionPlans\Pages\CreateSupervisionPlan;
use App\Filament\Resources\SupervisionPlans\Pages\EditSupervisionPlan;
use App\Filament\Resources\SupervisionPlans\Pages\ListSupervisionPlans;
use App\Filament\Resources\SupervisionPlans\Schemas\SupervisionPlanForm;
use App\Filament\Resources\SupervisionPlans\Tables\SupervisionPlansTable;
use App\Models\SupervisionPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SupervisionPlanResource extends Resource
{
    protected static ?string $model = SupervisionPlan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Perencanaan';

    protected static ?string $modelLabel = 'Rencana Pengawasan';

    protected static ?string $pluralModelLabel = 'Rencana Pengawasan';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return SupervisionPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SupervisionPlansTable::configure($table);
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
            'index' => ListSupervisionPlans::route('/'),
            'create' => CreateSupervisionPlan::route('/create'),
            'edit' => EditSupervisionPlan::route('/{record}/edit'),
        ];
    }
}
