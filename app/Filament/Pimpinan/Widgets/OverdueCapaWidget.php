<?php

namespace App\Filament\Pimpinan\Widgets;

use App\Enums\FindingStatus;
use App\Models\InspectionFinding;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class OverdueCapaWidget extends TableWidget
{
    protected static ?string $heading = 'Peringatan: Temuan Melewati Batas Waktu (Overdue)';

    protected static ?int $sort = 8;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => InspectionFinding::query()
                    ->with(['inspection.facility'])
                    ->where('status', FindingStatus::Open)
                    ->where('due_date', '<', now())
                    ->latest('due_date')
            )
            ->columns([
                TextColumn::make('inspection.facility.name')
                    ->label('Sarana')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('inspection.inspection_number')
                    ->label('No. Inspeksi')
                    ->searchable(),
                TextColumn::make('standard')
                    ->label('Standar')
                    ->badge(),
                TextColumn::make('description')
                    ->label('Uraian Temuan')
                    ->limit(45),
                TextColumn::make('due_date')
                    ->label('Batas Waktu')
                    ->date('d M Y')
                    ->badge()
                    ->color('danger'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
            ])
            ->emptyStateHeading('Tidak ada temuan yang terlambat')
            ->emptyStateDescription('Semua temuan CAPA masih dalam rentang waktu yang diizinkan.')
            ->paginated([5, 10]);
    }
}
