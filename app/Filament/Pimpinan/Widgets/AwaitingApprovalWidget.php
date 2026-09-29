<?php

namespace App\Filament\Pimpinan\Widgets;

use App\Enums\CapaClosureStatus;
use App\Models\CapaClosure;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class AwaitingApprovalWidget extends TableWidget
{
    protected static ?string $heading = 'CAPA Closure Menunggu Pengesahan Kepala Balai';

    protected static ?int $sort = 9;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => CapaClosure::query()
                    ->with(['inspection.facility', 'verifiedBy'])
                    ->where('status', CapaClosureStatus::PendingApproval)
                    ->latest()
            )
            ->columns([
                TextColumn::make('closure_number')
                    ->label('No. Penutupan CAPA')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('inspection.facility.name')
                    ->label('Sarana')
                    ->searchable(),
                TextColumn::make('verifiedBy.name')
                    ->label('Diverifikasi Oleh')
                    ->description(fn (CapaClosure $record): string => $record->verified_at ? $record->verified_at->format('d M Y H:i') : ''),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Diajukan Pada')
                    ->dateTime('d M Y H:i'),
            ])
            ->recordActions([
                Action::make('review')
                    ->label('Tinjau & Sahkan')
                    ->icon('heroicon-m-check-badge')
                    ->url(fn (CapaClosure $record): string => url("/pimpinan/capa-closures/{$record->id}/edit")),
            ])
            ->emptyStateHeading('Tidak ada dokumen yang menunggu pengesahan')
            ->emptyStateDescription('Seluruh dokumen CAPA Closure telah selesai disahkan.')
            ->paginated([5, 10]);
    }
}
