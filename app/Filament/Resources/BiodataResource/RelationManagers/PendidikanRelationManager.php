<?php

namespace App\Filament\Resources\BiodataResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;

class PendidikanRelationManager extends RelationManager
{
    protected static string $relationship = 'pendidikan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Information Biodata')
                    ->schema([
                        Forms\Components\Select::make('jenjang')
                            ->label('Jenjang')
                            ->required()
                            ->options([
                                'SD' => 'SD',
                                'SMP' => 'SMP',
                                'SMA' => 'SMA',
                                'SMK' => 'SMK',
                                'D-III' => 'D-III',
                                'D-IV' => 'D-IV',
                                'S1' => 'S1',
                                'S2' => 'S2',
                                'S3' => 'S3',
                                'Spesialis' => 'Spesialis',
                                'Profesi' => 'Profesi',
                                'D1' => 'D1',
                            ]),
                        Forms\Components\TextInput::make('program_studi')
                            ->label('Program Studi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('institusi')
                            ->label('Institusi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('no_ijasah')
                            ->label('No Ijazah')
                            ->nullable()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('institusi_spesialis')
                            ->label('Spesialis')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('no_ijasah_spesialis')
                            ->label('No Ijazah Spesialis')
                            ->nullable()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('institusi_subspesialis')
                            ->label('Sub Spesialis')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('no_ijasah_subspesialis')
                            ->label('No Ijazah Sub Spesialis')
                            ->nullable()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('keterangan')
                            ->label('Keterangan : Tahun Lulus dll')
                            ->nullable()
                            ->columnSpanFull()
                            ->maxLength(500),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('biodata_id')
            ->columns([
                Tables\Columns\TextColumn::make('jenjang')
                    ->label('Jenjang')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('program_studi')
                    ->label('Program Studi')
                    ->description(fn($record) => $record->institusi ?? 'Tidak ada data')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('institusi_spesialis')
                    ->label('Institusi Spesialis')
                    ->description(fn($record) => 'Sub : ' . $record->institusi_subspesialis ?? 'Tidak ada sub spesialis')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible(fn(RelationManager $livewire): bool => $livewire->ownerRecord->pendidikan()->count() === 0),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
