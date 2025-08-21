<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisTenagaResource\Pages;
use App\Filament\Resources\JenisTenagaResource\RelationManagers;
use App\Models\JenisTenaga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Referensi;

class JenisTenagaResource extends Resource
{
    protected static ?string $model = JenisTenaga::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Jenis Tenaga';
    protected static ?string $pluralModelLabel = 'Jenis Tenaga';
    protected static ?string $cluster = Referensi::class;
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Jenis Tenaga Information')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Jenis Tenaga')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Jenis Tenaga')
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
            'index' => Pages\ManageJenisTenagas::route('/'),
        ];
    }
}
