<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DirektoratResource\Pages;
use App\Filament\Resources\DirektoratResource\RelationManagers;
use App\Models\Direktorat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Referensi;

class DirektoratResource extends Resource
{
    protected static ?string $model = Direktorat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Direktorat';
    protected static ?string $pluralModelLabel = 'Direktorat';
    protected static ?string $cluster = Referensi::class;
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Direktorat Information')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Direktorat')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\Select::make('struktural_id')
                            ->label('Struktural')
                            ->required()
                            ->relationship('struktural', 'nama'),

                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan')
                            ->numeric()
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Direktorat')
                    ->sortable()
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
            'index' => Pages\ManageDirektorats::route('/'),
        ];
    }
}
