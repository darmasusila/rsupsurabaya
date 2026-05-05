<?php

namespace App\Filament\Resources\BiodataResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VaksinasiRelationManager extends RelationManager
{
    protected static string $relationship = 'vaksinasi';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('jenis_vaksin')
                    ->required()
                    ->options([
                        'Vaksin MR' => 'Vaksin MR',
                        'Vaksin Hepatitis B' => 'Vaksin Hepatitis B',
                        'Vaksin Influenza' => 'Vaksin Influenza',
                        'Vaksin COVID-19' => 'Vaksin COVID-19',
                        'Vaksin Tdap' => 'Vaksin Tdap',
                    ]),
                Forms\Components\DatePicker::make('tanggal_vaksin')
                    ->label('Tanggal Vaksin')
                    ->nullable(),
                Forms\Components\TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->columnSpanFull()
                    ->nullable()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('jenis_vaksin')
            ->columns([
                Tables\Columns\TextColumn::make('jenis_vaksin'),
                Tables\Columns\TextColumn::make('tanggal_vaksin')
                    ->date(),
                Tables\Columns\TextColumn::make('keterangan'),
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
