<?php

namespace App\Filament\Resources\Samplings\RelationManagers;

use App\Enums\ComplianceStatus;
use App\Models\TestParameter;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'testResults';

    protected static ?string $title = 'Hasil Uji Parameter Laboratorium';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    Select::make('test_parameter_id')
                        ->label('Parameter Uji')
                        ->relationship('testParameter', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Set $set, ?string $state) {
                            if ($state) {
                                $param = TestParameter::find($state);
                                if ($param && $param->result_unit) {
                                    $set('unit', $param->result_unit);
                                }
                            }
                        }),
                    TextInput::make('result_value')
                        ->label('Nilai Hasil Uji')
                        ->placeholder('misal: Negatif, 0.05, < 10')
                        ->required(),
                    TextInput::make('unit')
                        ->label('Satuan')
                        ->placeholder('misal: mg/kg, CFU/g')
                        ->required(),
                    TextInput::make('requirement_limit')
                        ->label('Batas Standar / Persyaratan')
                        ->placeholder('misal: Negatif / 25g, Maks. 50')
                        ->required(),
                    Select::make('compliance_status')
                        ->label('Status Kesesuaian')
                        ->options(ComplianceStatus::class)
                        ->required(),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('testParameter.name')
                    ->label('Parameter Uji')
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('testParameter.code')
                    ->label('Kode')
                    ->badge(),
                TextColumn::make('result_value')
                    ->label('Hasil Uji')
                    ->weight('medium'),
                TextColumn::make('unit')
                    ->label('Satuan'),
                TextColumn::make('requirement_limit')
                    ->label('Batas Persyaratan'),
                TextColumn::make('compliance_status')
                    ->label('Status')
                    ->badge(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Hasil Parameter'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
