<?php

namespace App\Filament\Resources\Roles\Schemas;

use App\Enums\PermissionType;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Peran')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Peran')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Contoh: admin, inspector, team_leader, head, business'),
                        TextInput::make('guard_name')
                            ->label('Guard')
                            ->default('web')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(),
                    ]),
                Section::make('Hak Akses (Permissions)')
                    ->description('Pilih permission yang dimiliki peran ini.')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->label('')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(function ($record): string {
                                $enum = PermissionType::tryFrom($record->name);

                                return $enum ? "{$enum->getLabel()} ({$record->name})" : $record->name;
                            })
                            ->columns(2)
                            ->searchable()
                            ->bulkToggleable(),
                    ]),
            ]);
    }
}
