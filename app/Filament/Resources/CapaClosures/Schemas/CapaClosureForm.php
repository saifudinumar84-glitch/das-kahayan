<?php

namespace App\Filament\Resources\CapaClosures\Schemas;

use App\Enums\CapaClosureStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CapaClosureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Surat Pengesahan Closed CAPA')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('inspection_id')
                                ->label('Pemeriksaan Terkait')
                                ->relationship('inspection', 'inspection_number')
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('letter_number')
                                ->label('Nomor Surat Closed CAPA')
                                ->default(fn () => 'CLP/'.date('Ymd').'/'.strtoupper(Str::random(6)))
                                ->required()
                                ->unique(ignoreRecord: true),
                            Select::make('status')
                                ->label('Status Pengesahan')
                                ->options(CapaClosureStatus::class)
                                ->default(CapaClosureStatus::PendingVerification)
                                ->required(),
                            FileUpload::make('file_path')
                                ->label('Berkas Surat Closed CAPA (PDF)')
                                ->directory('documents/closed_capa')
                                ->visibility('private'),
                        ]),
                    ]),

                Section::make('Riwayat Verifikasi & Pengesahan Digital')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('verified_by')
                                ->label('Diverifikasi Oleh (Ketua Tim)')
                                ->relationship('verifier', 'name')
                                ->disabled(),
                            DateTimePicker::make('verified_at')
                                ->label('Waktu Verifikasi')
                                ->disabled(),
                            Select::make('approved_by')
                                ->label('Disahkan Oleh (Kepala Balai)')
                                ->relationship('approver', 'name')
                                ->disabled(),
                            DateTimePicker::make('approved_at')
                                ->label('Waktu Pengesahan')
                                ->disabled(),
                            DateTimePicker::make('sent_at')
                                ->label('Waktu Dikirim ke Pelaku Usaha')
                                ->disabled(),
                        ]),
                    ])
                    ->collapsible(),
            ]);
    }
}
