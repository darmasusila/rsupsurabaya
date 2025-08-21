<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StrukturalResource\Pages;
use App\Filament\Resources\StrukturalResource\RelationManagers;
use App\Models\Struktural;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Referensi;

class StrukturalResource extends Resource
{
    protected static ?string $model = Struktural::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Struktural';
    protected static ?string $pluralModelLabel = 'Struktural';
    protected static ?string $cluster = Referensi::class;
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Struktural Information')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Struktural')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('keterangan')
                            ->label('Keterangan')
                            ->nullable()
                            ->maxLength(500),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Struktural')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50),
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
            'index' => Pages\ManageStrukturals::route('/'),
        ];
    }
}
