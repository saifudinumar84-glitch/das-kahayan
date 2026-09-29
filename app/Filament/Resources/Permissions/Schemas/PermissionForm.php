<?php

namespace App\Filament\Resources\Permissions\Schemas;

use App\Enums\PermissionType;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Hak Akses')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Permission')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->datalist(collect(PermissionType::cases())->map(fn (PermissionType $p): string => $p->value)->all())
                            ->helperText('Gunakan snake_case (pilih dari rekomendasi atau ketik baru). Contoh: kelola_inspeksi'),
                        TextInput::make('guard_name')
                            ->label('Guard')
                            ->default('web')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(),
                        Placeholder::make('enum_label')
                            ->label('Label dari Enum')
                            ->content(function (?string $state, $record): string {
                                if (! $record) {
                                    return '—';
                                }
                                $enum = PermissionType::tryFrom($record->name);

                                return $enum ? $enum->getLabel() : 'Tidak terdaftar di PermissionType';
                            }),
                    ]),
            ]);
    }
}
