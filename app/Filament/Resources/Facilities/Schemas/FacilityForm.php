<?php

namespace App\Filament\Resources\Facilities\Schemas;

use App\Enums\FacilityType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FacilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Sarana')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama Sarana / Perusahaan')
                                ->required()
                                ->maxLength(255),
                            Select::make('facility_type')
                                ->label('Jenis Sarana')
                                ->options(FacilityType::class)
                                ->required(),
                            TextInput::make('commodity_type')
                                ->label('Jenis Komoditas')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('regency')
                                ->label('Kabupaten / Kota')
                                ->required()
                                ->maxLength(100),
                            Textarea::make('address')
                                ->label('Alamat Lengkap')
                                ->required()
                                ->columnSpanFull(),
                            Toggle::make('is_active')
                                ->label('Sarana Aktif')
                                ->default(true)
                                ->required(),
                        ]),
                    ]),

                Section::make('Titik Koordinat')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('latitude')
                                ->label('Latitude')
                                ->numeric()
                                ->helperText('Contoh: -2.2136'),
                            TextInput::make('longitude')
                                ->label('Longitude')
                                ->numeric()
                                ->helperText('Contoh: 113.9108'),
                        ]),
                    ])
                    ->collapsible(),

                Section::make('Penanggung Jawab & Kontak')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('pic_name')
                                ->label('Nama Penanggung Jawab (PIC)')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('phone')
                                ->label('Nomor Telepon')
                                ->tel()
                                ->required()
                                ->maxLength(50),
                            TextInput::make('email')
                                ->label('Alamat Email')
                                ->email()
                                ->maxLength(255),
                        ]),
                    ]),

                Section::make('Legalitas & Sertifikasi (Data Sensitif)')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('nib')
                                ->label('NIB (Nomor Induk Berusaha)')
                                ->password()
                                ->revealable()
                                ->maxLength(255),
                            TextInput::make('npwp')
                                ->label('NPWP')
                                ->password()
                                ->revealable()
                                ->maxLength(255),
                            TextInput::make('nie_number')
                                ->label('Nomor Izin Edar (NIE)')
                                ->maxLength(255),
                            TextInput::make('cppob_certificate_number')
                                ->label('Nomor Sertifikat IP CPPOB')
                                ->maxLength(255),
                            DatePicker::make('cppob_certificate_valid_until')
                                ->label('Masa Berlaku Sertifikat CPPOB'),
                        ]),
                    ])
                    ->collapsible(),
            ]);
    }
}
