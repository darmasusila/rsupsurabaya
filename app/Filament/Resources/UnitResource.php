<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Pages;
use App\Filament\Resources\UnitResource\RelationManagers;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Referensi;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Unit Kerja';
    protected static ?string $pluralModelLabel = 'Unit Kerja';
    protected static ?string $cluster = Referensi::class;
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Unit Kerja Information')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Unit Kerja')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('direktorat_id')
                            ->label('Direktorat')
                            ->required()
                            ->relationship('direktorat', 'nama')
                            ->searchable(),
                        Forms\Components\Select::make('struktural_id')
                            ->label('Struktural')
                            ->required()
                            ->relationship('struktural', 'nama')
                            ->searchable(),
                        Forms\Components\TextInput::make('keterangan')
                            ->label('Keterangan')
                            ->nullable()
                            ->maxLength(500),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Unit Kerja')
                    ->searchable(),
                Tables\Columns\TextColumn::make('direktorat.nama')
                    ->label('Direktorat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('struktural.nama')
                    ->label('Struktural')
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
            'index' => Pages\ManageUnits::route('/'),
        ];
    }
}
