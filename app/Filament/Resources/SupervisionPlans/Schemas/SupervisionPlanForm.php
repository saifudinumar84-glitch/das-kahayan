<?php

namespace App\Filament\Resources\SupervisionPlans\Schemas;

use App\Enums\SupervisionPlanStatus;
use App\Enums\SupervisionPlanType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SupervisionPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Rencana Pengawasan')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('Judul Perencanaan')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Select::make('plan_type')
                                ->label('Jenis Pengawasan')
                                ->options(SupervisionPlanType::class)
                                ->required(),
                            Select::make('status')
                                ->label('Status Rencana')
                                ->options(SupervisionPlanStatus::class)
                                ->default(SupervisionPlanStatus::Draft)
                                ->required(),
                            DatePicker::make('period_start')
                                ->label('Periode Mulai')
                                ->required(),
                            DatePicker::make('period_end')
                                ->label('Periode Selesai')
                                ->required(),
                            Hidden::make('created_by')
                                ->default(fn () => auth()->id()),
                            Textarea::make('notes')
                                ->label('Catatan Perencanaan')
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
