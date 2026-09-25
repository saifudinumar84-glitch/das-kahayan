<?php

namespace App\Filament\Resources\Inspections\RelationManagers;

use App\Enums\FindingStatus;
use App\Enums\InspectionStandard;
use App\Models\InspectionFinding;
use App\Models\InspectionRequirement;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InspectionFindingsRelationManager extends RelationManager
{
    protected static string $relationship = 'findings';

    protected static ?string $title = 'Temuan Ketidaksesuaian (Pemeriksaan)';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    Select::make('standard')
                        ->label('Standar Ketidaksesuaian')
                        ->options(InspectionStandard::class)
                        ->default(InspectionStandard::Cppob)
                        ->required()
                        ->live(),
                    Select::make('requirement_id')
                        ->label('Klausul / Butir Persyaratan')
                        ->relationship('requirement', 'code')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set, ?string $state) {
                            if ($state) {
                                $req = InspectionRequirement::find($state);
                                if ($req) {
                                    $set('description', $req->description);
                                }
                            }
                        }),
                    DatePicker::make('due_date')
                        ->label('Batas Waktu Tindak Lanjut (Due Date)')
                        ->default(now()->addDays(14))
                        ->required(),
                    Select::make('status')
                        ->label('Status Temuan')
                        ->options(FindingStatus::class)
                        ->default(FindingStatus::Open)
                        ->required(),
                    Textarea::make('description')
                        ->label('Deskripsi Temuan Ketidaksesuaian')
                        ->required()
                        ->columnSpanFull(),
                    Textarea::make('recommendation')
                        ->label('Rekomendasi Tindakan Perbaikan')
                        ->required()
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('standard')
                    ->label('Standar')
                    ->badge(),
                TextColumn::make('requirement.code')
                    ->label('Klausul')
                    ->placeholder('-'),
                TextColumn::make('description')
                    ->label('Deskripsi Temuan')
                    ->limit(60)
                    ->wrap(),
                TextColumn::make('due_date')
                    ->label('Batas Waktu')
                    ->date('d M Y')
                    ->description(function (InspectionFinding $record): ?string {
                        if ($record->status === FindingStatus::Open && $record->due_date && $record->due_date->isPast()) {
                            return '⚠️ Terlambat!';
                        }

                        return null;
                    })
                    ->color(fn (InspectionFinding $record): ?string => ($record->status === FindingStatus::Open && $record->due_date && $record->due_date->isPast()) ? 'danger' : null)
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('capa_submissions_count')
                    ->counts('capaSubmissions')
                    ->label('Jumlah CAPA')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Temuan')
                    ->options(FindingStatus::class),
                SelectFilter::make('standard')
                    ->label('Standar')
                    ->options(InspectionStandard::class),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Catat Temuan Baru'),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('closeFinding')
                    ->label('Tutup Temuan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Tutup Temuan Ketidaksesuaian')
                    ->modalDescription('Pastikan perbaikan CAPA telah dievaluasi dan memenuhi syarat.')
                    ->visible(fn (InspectionFinding $record): bool => $record->status === FindingStatus::Open)
                    ->action(function (InspectionFinding $record) {
                        $record->update([
                            'status' => FindingStatus::Closed,
                            'closed_at' => now(),
                            'closed_by' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Temuan berhasil ditutup (Closed).')
                            ->success()
                            ->send();
                    }),
                Action::make('reopenFinding')
                    ->label('Buka Kembali')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (InspectionFinding $record): bool => $record->status === FindingStatus::Closed)
                    ->action(function (InspectionFinding $record) {
                        $record->update([
                            'status' => FindingStatus::Open,
                            'closed_at' => null,
                            'closed_by' => null,
                        ]);

                        Notification::make()
                            ->title('Temuan dibuka kembali (Open).')
                            ->warning()
                            ->send();
                    }),
                DeleteAction::make(),
            ]);
    }
}
