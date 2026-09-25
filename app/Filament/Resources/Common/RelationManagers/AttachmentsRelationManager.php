<?php

namespace App\Filament\Resources\Common\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class AttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'attachments';

    protected static ?string $title = 'Dokumen & Foto Bukti Lampiran';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('file_path')
                    ->label('Unggah Berkas / Foto Bukti')
                    ->directory('attachments')
                    ->visibility('private')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('caption')
                    ->label('Keterangan / Caption Foto')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Hidden::make('uploaded_by')
                    ->default(fn () => auth()->id()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('file_name')
                    ->label('Nama Berkas')
                    ->searchable()
                    ->default(fn ($record) => basename($record->file_path)),
                TextColumn::make('caption')
                    ->label('Keterangan')
                    ->wrap(),
                TextColumn::make('uploader.name')
                    ->label('Diunggah Oleh')
                    ->default('-'),
                TextColumn::make('created_at')
                    ->label('Waktu Unggah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Unggah Lampiran')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['uploaded_by'] = auth()->id();
                        $data['file_name'] = basename($data['file_path'] ?? 'file');
                        if (! empty($data['file_path']) && Storage::disk('local')->exists($data['file_path'])) {
                            $data['size_kb'] = (int) round(Storage::disk('local')->size($data['file_path']) / 1024);
                            $data['mime'] = Storage::disk('local')->mimeType($data['file_path']) ?? 'application/octet-stream';
                        }

                        return $data;
                    }),
            ])
            ->recordActions([
                DeleteAction::make(),
            ]);
    }
}
