<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengguna')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('email')
                                ->label('Alamat Email')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),
                            TextInput::make('phone')
                                ->label('Nomor Telepon')
                                ->tel()
                                ->maxLength(50),
                            Select::make('role')
                                ->label('Peran (Role)')
                                ->options(UserRole::class)
                                ->default(UserRole::Inspector)
                                ->required(),
                            TextInput::make('password')
                                ->label('Kata Sandi')
                                ->password()
                                ->dehydrated(fn (?string $state): bool => filled($state))
                                ->required(fn (string $operation): bool => $operation === 'create'),
                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->default(true)
                                ->required(),
                        ]),
                        FileUpload::make('signature_path')
                            ->label('Tanda Tangan Digital (Gambar)')
                            ->image()
                            ->directory('signatures')
                            ->visibility('private')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
