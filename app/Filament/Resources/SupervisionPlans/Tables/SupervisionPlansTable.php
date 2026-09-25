<?php

namespace App\Filament\Resources\SupervisionPlans\Tables;

use App\Enums\SupervisionPlanStatus;
use App\Enums\SupervisionPlanType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SupervisionPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Perencanaan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('plan_type')
                    ->label('Jenis')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('period_start')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('period_end')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('creator.name')
                    ->label('Disusun Oleh')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('plan_type')
                    ->label('Jenis Pengawasan')
                    ->options(SupervisionPlanType::class),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(SupervisionPlanStatus::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
