<?php

namespace App\Filament\Resources\BiodataResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendidikanRelationManager extends RelationManager
{
    protected static string $relationship = 'pendidikan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('biodata_id')
                    ->required()
                    ->maxLength(255),
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

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
