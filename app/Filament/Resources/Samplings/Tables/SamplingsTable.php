<?php

namespace App\Filament\Resources\Samplings\Tables;

use App\Enums\PublicationStatus;
use App\Enums\SamplingConclusion;
use App\Enums\SamplingStatus;
use App\Models\Sampling;
use App\Models\StatusHistory;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SamplingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sampling_number')
                    ->label('No. Sampling')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('sampling_date')
                    ->label('Tanggal Sampling')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('product_name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->description(fn (Sampling $record): ?string => $record->brand ? "Merk: {$record->brand}" : null),
                TextColumn::make('foodType.name')
                    ->label('Jenis Pangan')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('conclusion')
                    ->label('Kesimpulan Uji')
                    ->badge()
                    ->placeholder('Belum Ada')
                    ->sortable(),
                TextColumn::make('publication_status')
                    ->label('Publikasi')
                    ->badge()
                    ->sortable(),
                TextColumn::make('inspector.name')
                    ->label('Petugas')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sampling_location')
                    ->label('Lokasi Sampling')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Sampling')
                    ->options(SamplingStatus::class),
                SelectFilter::make('conclusion')
                    ->label('Kesimpulan Uji')
                    ->options(SamplingConclusion::class),
                SelectFilter::make('publication_status')
                    ->label('Status Publikasi')
                    ->options(PublicationStatus::class),
                SelectFilter::make('food_type_id')
                    ->label('Jenis Pangan')
                    ->relationship('foodType', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('publish')
                    ->label('Publikasikan')
                    ->icon('heroicon-o-globe-alt')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Publikasikan Hasil Sampling')
                    ->modalDescription('Hasil sampling dan kesimpulan uji akan dapat dilihat oleh publik di portal informasi.')
                    ->visible(fn (Sampling $record): bool => $record->publication_status !== PublicationStatus::Published && in_array(auth()->user()?->role?->value, ['admin', 'team_leader'], true))
                    ->action(function (Sampling $record) {
                        $old = $record->publication_status->value;
                        $record->update([
                            'publication_status' => PublicationStatus::Published,
                            'published_at' => now(),
                            'published_by' => auth()->id(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => Sampling::class,
                            'statusable_id' => $record->id,
                            'old_status' => $old,
                            'new_status' => 'published',
                            'user_id' => auth()->id(),
                            'notes' => 'Hasil sampling dipublikasikan ke portal publik.',
                        ]);

                        Notification::make()
                            ->title('Hasil sampling berhasil dipublikasikan!')
                            ->success()
                            ->send();
                    }),
                Action::make('unpublish')
                    ->label('Tarik Publikasi')
                    ->icon('heroicon-o-eye-slash')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->visible(fn (Sampling $record): bool => $record->publication_status === PublicationStatus::Published && in_array(auth()->user()?->role?->value, ['admin', 'team_leader'], true))
                    ->action(function (Sampling $record) {
                        $record->update([
                            'publication_status' => PublicationStatus::Unpublished,
                            'published_at' => null,
                            'published_by' => null,
                        ]);

                        Notification::make()
                            ->title('Publikasi berhasil ditarik.')
                            ->warning()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
