<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatusKepegawaianResource\Pages;
use App\Filament\Resources\StatusKepegawaianResource\RelationManagers;
use App\Models\StatusKepegawaian;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Referensi;

class StatusKepegawaianResource extends Resource
{
    protected static ?string $model = StatusKepegawaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Status Kepegawaian';
    protected static ?string $cluster = Referensi::class;
    protected static ?string $pluralModelLabel = 'Status Kepegawaian';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Status Kepegawaian Information')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Status Kepegawaian')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

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
                    ->label('Nama Status Kepegawaian')
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
            'index' => Pages\ManageStatusKepegawaians::route('/'),
        ];
    }
}
