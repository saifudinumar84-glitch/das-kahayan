<?php

namespace App\Filament\Resources\Inspections\RelationManagers;

use App\Enums\CapaSubmissionStatus;
use App\Enums\FindingStatus;
use App\Models\CapaSubmission;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CapaSubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'capaSubmissions';

    protected static ?string $title = 'Tindak Lanjut CAPA (Perbaikan & Pencegahan)';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('round')
                    ->label('Ronde Ke-')
                    ->badge()
                    ->sortable(),
                TextColumn::make('corrective_action')
                    ->label('Tindakan Perbaikan (Corrective)')
                    ->limit(60)
                    ->wrap(),
                TextColumn::make('preventive_action')
                    ->label('Tindakan Pencegahan (Preventive)')
                    ->limit(60)
                    ->wrap(),
                TextColumn::make('status')
                    ->label('Status Evaluasi')
                    ->badge()
                    ->sortable(),
                TextColumn::make('submitter.name')
                    ->label('Pengirim (Pelaku Usaha)'),
                TextColumn::make('submitted_at')
                    ->label('Tanggal Kirim')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('reviewer.name')
                    ->label('Evaluator')
                    ->placeholder('-'),
                TextColumn::make('review_notes')
                    ->label('Catatan Evaluasi')
                    ->limit(40)
                    ->wrap()
                    ->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(CapaSubmissionStatus::class),
            ])
            ->recordActions([
                Action::make('acceptCapa')
                    ->label('Terima CAPA')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Terima Tindak Lanjut CAPA')
                    ->modalDescription('Dengan menerima CAPA ini, status temuan ketidaksesuaian akan otomatis ditutup (Closed).')
                    ->visible(fn (CapaSubmission $record): bool => $record->status === CapaSubmissionStatus::Submitted)
                    ->action(function (CapaSubmission $record) {
                        $record->update([
                            'status' => CapaSubmissionStatus::Accepted,
                            'reviewed_by' => auth()->id(),
                            'reviewed_at' => now(),
                        ]);

                        $finding = $record->finding;
                        if ($finding) {
                            $finding->update([
                                'status' => FindingStatus::Closed,
                                'closed_at' => now(),
                                'closed_by' => auth()->id(),
                            ]);
                        }

                        Notification::make()
                            ->title('CAPA diterima dan temuan berhasil ditutup!')
                            ->success()
                            ->send();
                    }),
                Action::make('rejectCapa')
                    ->label('Tolak CAPA')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Textarea::make('review_notes')
                            ->label('Alasan Penolakan / Catatan Perbaikan Tambahan')
                            ->required()
                            ->placeholder('Jelaskan mengapa tindakan perbaikan belum memenuhi syarat...'),
                    ])
                    ->visible(fn (CapaSubmission $record): bool => $record->status === CapaSubmissionStatus::Submitted)
                    ->action(function (array $data, CapaSubmission $record) {
                        $record->update([
                            'status' => CapaSubmissionStatus::Rejected,
                            'review_notes' => $data['review_notes'],
                            'reviewed_by' => auth()->id(),
                            'reviewed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('CAPA ditolak. Pelaku usaha dapat mengirimkan ronde perbaikan berikutnya.')
                            ->warning()
                            ->send();
                    }),
            ])
            ->defaultSort('round', 'desc');
    }
}
