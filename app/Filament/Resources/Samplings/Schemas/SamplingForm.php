<?php

namespace App\Filament\Resources\Samplings\Schemas;

use App\Enums\PublicationStatus;
use App\Enums\SamplingConclusion;
use App\Enums\SamplingStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SamplingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Produk & Sampling')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('sampling_number')
                                ->label('Nomor Sampling')
                                ->default(fn () => 'SMP-'.date('Ymd').'-'.strtoupper(Str::random(4)))
                                ->required()
                                ->unique(ignoreRecord: true),
                            Select::make('plan_id')
                                ->label('Rencana Pengawasan')
                                ->relationship('plan', 'title')
                                ->searchable()
                                ->preload(),
                            Select::make('inspector_id')
                                ->label('Petugas Sampling (Inspektur)')
                                ->relationship('inspector', 'name')
                                ->default(fn () => auth()->id())
                                ->required()
                                ->searchable(),
                            DatePicker::make('sampling_date')
                                ->label('Tanggal Sampling')
                                ->default(now())
                                ->required(),
                            TextInput::make('product_name')
                                ->label('Nama Produk Pangan')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('brand')
                                ->label('Merk / Brand')
                                ->maxLength(255),
                            Select::make('food_type_id')
                                ->label('Jenis Pangan')
                                ->relationship('foodType', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('sampling_facility_id')
                                ->label('Sarana Tempat Sampling (Opsional)')
                                ->relationship('facility', 'name')
                                ->searchable()
                                ->preload(),
                            TextInput::make('purchase_price')
                                ->label('Harga Beli Sampel')
                                ->numeric()
                                ->prefix('Rp ')
                                ->default(0),
                            Textarea::make('sampling_location')
                                ->label('Lokasi / Tempat Pengambilan Sampel')
                                ->placeholder('Contoh: Pasar Besar Palangka Raya, Kios Bu Siti Blok B No. 4')
                                ->required()
                                ->columnSpanFull(),
                        ]),
                    ]),

                Section::make('Geolokasi Lapangan')
                    ->description('Koordinat lokasi saat pengambilan sampel di lapangan')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('geo_latitude')
                                ->label('Latitude')
                                ->numeric()
                                ->placeholder('Terisi otomatis saat geotagging'),
                            TextInput::make('geo_longitude')
                                ->label('Longitude')
                                ->numeric()
                                ->placeholder('Terisi otomatis saat geotagging'),
                            TextInput::make('geo_accuracy_m')
                                ->label('Akurasi (Meter)')
                                ->numeric(),
                            DateTimePicker::make('geo_captured_at')
                                ->label('Waktu Geotagging Direkam'),
                        ]),
                    ])
                    ->collapsible(),

                Section::make('Hasil Pengujian Laboratorium')
                    ->schema([
                        Grid::make(2)->schema([
                            DatePicker::make('test_date')
                                ->label('Tanggal Pengujian'),
                            Select::make('status')
                                ->label('Status Sampling')
                                ->options(SamplingStatus::class)
                                ->default(SamplingStatus::Planned)
                                ->live()
                                ->required(),
                            Select::make('conclusion')
                                ->label('Kesimpulan Akhir Uji')
                                ->options(SamplingConclusion::class)
                                ->visible(fn (Get $get): bool => in_array($get('status'), [SamplingStatus::Completed->value, 'completed'], true)),
                        ]),
                        Textarea::make('conclusion_notes')
                            ->label('Keterangan / Catatan Kesimpulan')
                            ->placeholder('Jelaskan detail ketidaksesuaian jika TMS...')
                            ->required(fn (Get $get): bool => in_array($get('conclusion'), [SamplingConclusion::NonCompliant->value, 'non_compliant'], true))
                            ->columnSpanFull(),
                        Textarea::make('recommendation')
                            ->label('Rekomendasi Tindak Lanjut')
                            ->placeholder('Rekomendasi tindakan yang disarankan...')
                            ->required(fn (Get $get): bool => in_array($get('conclusion'), [SamplingConclusion::NonCompliant->value, 'non_compliant'], true))
                            ->columnSpanFull(),
                    ]),

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
