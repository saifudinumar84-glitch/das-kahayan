<?php

namespace App\Filament\Resources\Inspections\Tables;

use App\Enums\InspectionStatus;
use App\Enums\PublicationStatus;
use App\Models\BapDocument;
use App\Models\Inspection;
use App\Models\StatusHistory;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class InspectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inspection_number')
                    ->label('No. Pemeriksaan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('inspection_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('facility.name')
                    ->label('Nama Sarana')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('facility.regency')
                    ->label('Kab/Kota')
                    ->badge()
                    ->sortable(),
                TextColumn::make('grade')
                    ->label('Grade')
                    ->badge()
                    ->placeholder('-'),
                TextColumn::make('findings_count')
                    ->counts('findings')
                    ->label('Temuan')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'danger' : 'success')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('publication_status')
                    ->label('Publikasi')
                    ->badge()
                    ->sortable(),
                TextColumn::make('inspector.name')
                    ->label('Inspektur')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pemeriksaan')
                    ->options(InspectionStatus::class),
                SelectFilter::make('publication_status')
                    ->label('Status Publikasi')
                    ->options(PublicationStatus::class),
                SelectFilter::make('facility_id')
                    ->label('Sarana')
                    ->relationship('facility', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('issueBap')
                    ->label('Terbitkan BAP')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Terbitkan Dokumen BAP')
                    ->modalDescription('Dokumen Berita Acara Pemeriksaan (BAP) resmi akan dibuat dengan QR Token validasi.')
                    ->visible(fn (Inspection $record): bool => in_array($record->status, [InspectionStatus::Planned, InspectionStatus::InProgress], true))
                    ->action(function (Inspection $record) {
                        $old = $record->status->value;
                        $docNumber = 'BAP/'.date('Ymd').'/'.strtoupper(Str::random(6));
                        $qrToken = Str::uuid()->toString();

                        $record->load(['facility', 'inspector', 'findings.requirement']);

                        BapDocument::updateOrCreate(
                            ['inspection_id' => $record->id],
                            [
                                'document_number' => $docNumber,
                                'file_path' => 'documents/bap/'.$record->id.'.pdf',
                                'qr_token' => $qrToken,
                                'content_snapshot' => [
                                    'inspection_number' => $record->inspection_number,
                                    'facility' => $record->facility?->toArray(),
                                    'inspector' => $record->inspector?->name,
                                    'date' => $record->inspection_date?->toDateString(),
                                    'grade' => $record->grade,
                                    'conclusion' => $record->conclusion,
                                    'findings' => $record->findings->map(fn ($f) => [
                                        'requirement' => $f->requirement?->code,
                                        'standard' => $f->standard?->value,
                                        'description' => $f->description,
                                        'recommendation' => $f->recommendation,
                                        'due_date' => $f->due_date?->toDateString(),
                                    ])->toArray(),
                                ],
                                'generated_at' => now(),
                                'sent_to_email' => $record->facility?->email,
                            ]
                        );

                        // If has findings, go to awaiting_capa, else completed
                        $newStatus = $record->findings()->exists()
                            ? InspectionStatus::AwaitingCapa
                            : InspectionStatus::Completed;

                        $record->update(['status' => $newStatus]);

                        StatusHistory::create([
                            'statusable_type' => Inspection::class,
                            'statusable_id' => $record->id,
                            'old_status' => $old,
                            'new_status' => $newStatus->value,
                            'user_id' => auth()->id(),
                            'notes' => "BAP resmi {$docNumber} berhasil diterbitkan.",
                        ]);

                        Notification::make()
                            ->title("BAP {$docNumber} Berhasil Diterbitkan!")
                            ->success()
                            ->send();
                    }),
                Action::make('publish')
                    ->label('Publikasikan')
                    ->icon('heroicon-o-globe-alt')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Publikasikan Hasil Pemeriksaan')
                    ->modalDescription('Hasil pemeriksaan sarana akan dapat dilihat oleh publik di portal informasi.')
                    ->visible(fn (Inspection $record): bool => $record->publication_status !== PublicationStatus::Published && in_array(auth()->user()?->role?->value, ['admin', 'team_leader'], true))
                    ->action(function (Inspection $record) {
                        $old = $record->publication_status->value;
                        $record->update([
                            'publication_status' => PublicationStatus::Published,
                            'published_at' => now(),
                            'published_by' => auth()->id(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => Inspection::class,
                            'statusable_id' => $record->id,
                            'old_status' => $old,
                            'new_status' => 'published',
                            'user_id' => auth()->id(),
                            'notes' => 'Hasil pemeriksaan sarana dipublikasikan ke publik.',
                        ]);

                        Notification::make()
                            ->title('Hasil pemeriksaan sarana berhasil dipublikasikan!')
                            ->success()
                            ->send();
                    }),
                Action::make('unpublish')
                    ->label('Tarik Publikasi')
                    ->icon('heroicon-o-eye-slash')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->visible(fn (Inspection $record): bool => $record->publication_status === PublicationStatus::Published && in_array(auth()->user()?->role?->value, ['admin', 'team_leader'], true))
                    ->action(function (Inspection $record) {
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
