<?php

namespace App\Filament\Resources\Common\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StatusHistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'statusHistories';

    protected static ?string $title = 'Riwayat Perubahan Status';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu Perubahan')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),
                TextColumn::make('old_status')
                    ->label('Status Sebelumnya')
                    ->badge()
                    ->placeholder('-'),
                TextColumn::make('new_status')
                    ->label('Status Baru')
                    ->badge(),
                TextColumn::make('user.name')
                    ->label('Pengubah Status')
                    ->default('Sistem'),
                TextColumn::make('notes')
                    ->label('Catatan Perubahan')
                    ->wrap(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
