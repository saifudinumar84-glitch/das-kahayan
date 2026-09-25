<?php

namespace App\Filament\Resources\Facilities\Tables;

use App\Enums\FacilityType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class FacilitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Sarana')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('facility_type')
                    ->label('Jenis Sarana')
                    ->badge()
                    ->sortable(),
                TextColumn::make('commodity_type')
                    ->label('Komoditas')
                    ->searchable(),
                TextColumn::make('regency')
                    ->label('Kabupaten/Kota')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pic_name')
                    ->label('Penanggung Jawab')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('cppob_certificate_number')
                    ->label('No. IP CPPOB')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Didaftarkan')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('facility_type')
                    ->label('Jenis Sarana')
                    ->options(FacilityType::class),
                SelectFilter::make('regency')
                    ->label('Kabupaten / Kota')
                    ->options([
                        'Kota Palangka Raya' => 'Kota Palangka Raya',
                        'Kabupaten Barito Selatan' => 'Kabupaten Barito Selatan',
                        'Kabupaten Barito Timur' => 'Kabupaten Barito Timur',
                        'Kabupaten Barito Utara' => 'Kabupaten Barito Utara',
                        'Kabupaten Gunung Mas' => 'Kabupaten Gunung Mas',
                        'Kabupaten Kapuas' => 'Kabupaten Kapuas',
                        'Kabupaten Katingan' => 'Kabupaten Katingan',
                        'Kabupaten Kotawaringin Barat' => 'Kabupaten Kotawaringin Barat',
                        'Kabupaten Kotawaringin Timur' => 'Kabupaten Kotawaringin Timur',
                        'Kabupaten Lamandau' => 'Kabupaten Lamandau',
                        'Kabupaten Murung Raya' => 'Kabupaten Murung Raya',
                        'Kabupaten Pulang Pisau' => 'Kabupaten Pulang Pisau',
                        'Kabupaten Sukamara' => 'Kabupaten Sukamara',
                        'Kabupaten Seruyan' => 'Kabupaten Seruyan',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
