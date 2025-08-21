<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Referensi;
use App\Filament\Resources\FungsionalResource\Pages;
use App\Filament\Resources\FungsionalResource\RelationManagers;
use App\Models\Fungsional;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Section;



class FungsionalResource extends Resource
{
    protected static ?string $model = Fungsional::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Fungsional';
    protected static ?string $pluralModelLabel = 'Fungsional';
    protected static ?int $navigationSort = 1;
    protected static ?string $cluster = Referensi::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Fungsional Information')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Fungsional')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\Toggle::make('is_str')
                            ->label('Ada STR?')
                            ->onIcon('heroicon-o-check')
                            ->offIcon('heroicon-o-x-mark'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Fungsional')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_str')
                    ->label('Ada STR?')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark'),
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
            'index' => Pages\ManageFungsionals::route('/'),
        ];
    }
}
