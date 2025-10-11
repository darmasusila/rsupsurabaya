<?php

namespace App\Filament\Clusters\Referensi\Resources;

use App\Filament\Clusters\Referensi;
use App\Filament\Clusters\Referensi\Resources\DepartemenResource\Pages;
use App\Filament\Clusters\Referensi\Resources\DepartemenResource\RelationManagers;
use App\Models\Departemen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartemenResource extends Resource
{
    protected static ?string $model = Departemen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Referensi::class;

    protected static ?string $navigationLabel = 'Departemen';
    protected static ?string $pluralModelLabel = 'Departemen';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Departemen')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('direktorat_id')
                    ->label('Direktorat')
                    ->required()
                    ->relationship('direktorat', 'nama'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Departemen')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('direktorat.nama')
                    ->label('Direktorat')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDepartemens::route('/'),
        ];
    }
}
