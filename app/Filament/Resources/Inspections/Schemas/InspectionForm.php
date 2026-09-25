<?php

namespace App\Filament\Resources\Inspections\Schemas;

use App\Enums\InspectionStatus;
use App\Enums\PublicationStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class InspectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pemeriksaan Sarana')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('inspection_number')
                                ->label('Nomor Pemeriksaan')
                                ->default(fn () => 'INS-'.date('Ymd').'-'.strtoupper(Str::random(4)))
                                ->required()
                                ->unique(ignoreRecord: true),
                            Select::make('plan_id')
                                ->label('Rencana Pengawasan')
                                ->relationship('plan', 'title')
                                ->searchable()
                                ->preload(),
                            Select::make('facility_id')
                                ->label('Sarana yang Diperiksa')
                                ->relationship('facility', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('inspector_id')
                                ->label('Petugas Inspektur')
                                ->relationship('inspector', 'name')
                                ->default(fn () => auth()->id())
                                ->required()
                                ->searchable(),
                            DatePicker::make('inspection_date')
                                ->label('Tanggal Pemeriksaan')
                                ->default(now())
                                ->required(),
                            Select::make('status')
                                ->label('Status Pemeriksaan')
                                ->options(InspectionStatus::class)
                                ->default(InspectionStatus::Planned)
                                ->required(),
                            TextInput::make('grade')
                                ->label('Rating / Nilai / Grade Sarana')
                                ->placeholder('misal: Level 1 (Sangat Baik), Level 2 (Baik), dst.')
                                ->maxLength(50),
                            Textarea::make('conclusion')
                                ->label('Kesimpulan Hasil Penilaian Inspeksi')
                                ->placeholder('Ringkasan hasil evaluasi kesesuaian sarana...')
                                ->columnSpanFull(),
                        ]),
                    ]),

                Section::make('Geolokasi Lapangan')
                    ->description('Koordinat saat petugas memulai pemeriksaan di sarana')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('geo_latitude')
                                ->label('Latitude')
                                ->numeric()
                                ->placeholder('Terisi otomatis'),
                            TextInput::make('geo_longitude')
                                ->label('Longitude')
                                ->numeric()
                                ->placeholder('Terisi otomatis'),
                            TextInput::make('geo_accuracy_m')
                                ->label('Akurasi (Meter)')
                                ->numeric(),
                            DateTimePicker::make('geo_captured_at')
                                ->label('Waktu Geotagging Direkam'),
                        ]),
                    ])
                    ->collapsible(),

                Section::make('Status Publikasi')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('publication_status')
                                ->label('Status Publikasi')
                                ->options(PublicationStatus::class)
                                ->default(PublicationStatus::Unpublished)
                                ->required(),
                            DateTimePicker::make('published_at')
                                ->label('Waktu Dipublikasikan')
                                ->disabled(),
                        ]),
                    ])
                    ->collapsible(),
            ]);
    }
}
