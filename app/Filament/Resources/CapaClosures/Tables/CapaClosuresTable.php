<?php

namespace App\Filament\Resources\CapaClosures\Tables;

use App\Enums\CapaClosureStatus;
use App\Models\CapaClosure;
use App\Models\StatusHistory;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CapaClosuresTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('letter_number')
                    ->label('No. Surat Closed CAPA')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('inspection.inspection_number')
                    ->label('No. Pemeriksaan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('inspection.facility.name')
                    ->label('Nama Sarana')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('status')
                    ->label('Status Pengesahan')
                    ->badge()
                    ->sortable(),
                TextColumn::make('verifier.name')
                    ->label('Verifikator')
                    ->placeholder('-'),
                TextColumn::make('approver.name')
                    ->label('Disahkan Oleh')
                    ->placeholder('-'),
                TextColumn::make('sent_at')
                    ->label('Dikirim')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Belum dikirim')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(CapaClosureStatus::class),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('verify')
                    ->label('Verifikasi (Ketua Tim)')
                    ->icon('heroicon-o-check')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Closed CAPA')
                    ->modalDescription('Pastikan seluruh temuan telah ditutup dan evaluasi CAPA sesuai sebelum diteruskan ke Kepala Balai.')
                    ->visible(fn (CapaClosure $record): bool => $record->status === CapaClosureStatus::PendingVerification && in_array(auth()->user()?->role?->value, ['admin', 'team_leader'], true))
                    ->action(function (CapaClosure $record) {
                        $record->update([
                            'status' => CapaClosureStatus::PendingApproval,
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => CapaClosure::class,
                            'statusable_id' => $record->id,
                            'old_status' => CapaClosureStatus::PendingVerification->value,
                            'new_status' => CapaClosureStatus::PendingApproval->value,
                            'user_id' => auth()->id(),
                            'notes' => 'Closed CAPA telah diverifikasi oleh Ketua Tim dan diteruskan ke Kepala Balai.',
                        ]);

                        Notification::make()
                            ->title('Closed CAPA berhasil diverifikasi!')
                            ->success()
                            ->send();
                    }),
                Action::make('approve')
                    ->label('Sahkan (Kepala Balai)')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Pengesahan Digital Surat Closed CAPA')
                    ->modalDescription('Apakah Anda yakin menyetujui dan mengesahkan penutupan temuan inspeksi (Closed CAPA) ini secara resmi?')
                    ->visible(fn (CapaClosure $record): bool => $record->status === CapaClosureStatus::PendingApproval && in_array(auth()->user()?->role?->value, ['admin', 'head'], true))
                    ->action(function (CapaClosure $record) {
                        $record->update([
                            'status' => CapaClosureStatus::Approved,
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => CapaClosure::class,
                            'statusable_id' => $record->id,
                            'old_status' => CapaClosureStatus::PendingApproval->value,
                            'new_status' => CapaClosureStatus::Approved->value,
                            'user_id' => auth()->id(),
                            'notes' => 'Closed CAPA resmi disahkan secara digital oleh Kepala Balai.',
                        ]);

                        Notification::make()
                            ->title('Surat Closed CAPA resmi disahkan oleh Kepala Balai!')
                            ->success()
                            ->send();
                    }),
                Action::make('sendToBusiness')
                    ->label('Kirim ke Pelaku Usaha')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Surat Closed CAPA')
                    ->modalDescription('Surat resmi Closed CAPA akan dikirimkan ke email dan akun pelaku usaha.')
                    ->visible(fn (CapaClosure $record): bool => $record->status === CapaClosureStatus::Approved)
                    ->action(function (CapaClosure $record) {
                        $record->update([
                            'status' => CapaClosureStatus::Sent,
                            'sent_at' => now(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => CapaClosure::class,
                            'statusable_id' => $record->id,
                            'old_status' => CapaClosureStatus::Approved->value,
                            'new_status' => CapaClosureStatus::Sent->value,
                            'user_id' => auth()->id(),
                            'notes' => 'Surat Closed CAPA telah dikirim ke pelaku usaha.',
                        ]);

                        Notification::make()
                            ->title('Surat Closed CAPA berhasil dikirim ke pelaku usaha!')
                            ->success()
                            ->send();
                    }),
                Action::make('returnClosure')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Kembalikan Dokumen Closed CAPA')
                    ->visible(fn (CapaClosure $record): bool => in_array($record->status, [CapaClosureStatus::PendingVerification, CapaClosureStatus::PendingApproval], true))
                    ->action(function (CapaClosure $record) {
                        $record->update([
                            'status' => CapaClosureStatus::Returned,
                        ]);

                        Notification::make()
                            ->title('Dokumen Closed CAPA dikembalikan untuk perbaikan.')
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
