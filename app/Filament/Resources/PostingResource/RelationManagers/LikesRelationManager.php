<?php

namespace App\Filament\Resources\PostingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Termwind\Components\Li;

class LikesRelationManager extends RelationManager
{
    protected static string $relationship = 'likes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pegawai_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('pegawai.biodata.nama')
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.biodata.nama')
                    ->label('Nama Pegawai')
                    ->description(fn($record): string => (isset($record->biodata->gelar_depan) ? $record->biodata->gelar_depan : ' ') . ' ' . (isset($record->biodata->gelar_belakang) ? $record->biodata->gelar_belakang : ''))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_open_link')
                    ->label('Open Link?')
                    ->sortable()
                    ->afterStateUpdated(
                        function ($state, $record) {
                            $record->update([
                                'is_open_link' => $state,
                                'updated_at' => now(),
                                'tanggal_liked' => $state ? now() : null,
                            ]);
                        }
                    ),
                Tables\Columns\TextColumn::make('tanggal_liked')
                    ->label('Tanggal Klik')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_not_open_link')
                    ->label('No Open Link?')
                    ->query(
                        fn(Builder $query) =>
                        $query->where('is_open_link', 0)
                    )
                    ->default(true),
                Tables\Filters\Filter::make('is_open_link')
                    ->label('Open Link?')
                    ->query(
                        fn(Builder $query) =>
                        $query->where('is_open_link', 1)
                    ),
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
