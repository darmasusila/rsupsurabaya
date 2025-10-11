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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\MultiSelectFilter;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Unit Kerja';
    protected static ?string $pluralModelLabel = 'Unit Kerja';
    protected static ?string $cluster = Referensi::class;
    protected static ?int $navigationSort = 7;

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

                        Forms\Components\Select::make('departemen_id')
                            ->label('Departemen')
                            ->required()
                            ->relationship('departemen', 'nama')
                            ->searchable(),
                        Forms\Components\Select::make('direktorat_id')
                            ->label('Direktorat')
                            ->required()
                            ->relationship('direktorat', 'nama')
                            ->searchable(),
                        Forms\Components\Select::make('struktural_id')
                            ->label('Struktural')
                            ->required()
                            ->relationship('struktural', 'nama')
                            ->options(function (callable $get) {
                                return \App\Models\Struktural::pluck('nama', 'id');
                            })
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
                Tables\Columns\TextColumn::make('departemen.nama')
                    ->label('Departemen')
                    ->searchable(),
                Tables\Columns\TextColumn::make('direktorat.nama')
                    ->label('Direktorat')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('departemen')->relationship('departemen', 'nama'),
                Tables\Filters\SelectFilter::make('direktorat')->relationship('direktorat', 'nama'),
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
