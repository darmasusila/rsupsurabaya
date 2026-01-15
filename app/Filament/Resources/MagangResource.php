<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MagangResource\Pages;
use App\Filament\Resources\MagangResource\RelationManagers;
use App\Models\Magang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Columns\Summarizers\Count;

class MagangResource extends Resource
{
    protected static ?string $model = Magang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Magang';
    protected static ?string $pluralModelLabel = 'Data Magang';
    protected static ?string $modelLabel = 'Magang';
    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('biodata_id')
                    ->required()
                    ->relationship('biodata', 'nama'),
                Forms\Components\Select::make('jenis_tenaga_id')
                    ->relationship('jenisTenaga', 'nama'),
                Forms\Components\Select::make('status_kepegawaian_id')
                    ->relationship('statusKepegawaian', 'nama'),
                Forms\Components\Select::make('unit_id')
                    ->relationship('unit', 'nama'),
                Forms\Components\Select::make('mentor_id')
                    ->label('Mentor')
                    ->nullable()
                    ->searchable()
                    ->options(function () {
                        return \App\Models\Pegawai::all()->pluck('biodata.nama', 'id');
                    }),
                Forms\Components\TextInput::make('ipk')
                    ->label('IPK')
                    ->numeric(),
                Forms\Components\DatePicker::make('tanggal_mulai'),
                Forms\Components\DatePicker::make('tanggal_selesai'),
                Forms\Components\TextInput::make('instansi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pendidikan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('posisi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('penempatan')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
                Forms\Components\Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('biodata.nama')
                    ->label('Nama Peserta')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenisTenaga.nama')
                    ->label('Jenis Tenaga')
                    ->sortable(),
                Tables\Columns\TextColumn::make('statusKepegawaian.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ipk')
                    ->label('IPK')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_tenaga_id')
                    ->label('Jenis Tenaga')
                    ->relationship('jenisTenaga', 'nama'),
                Tables\Filters\SelectFilter::make('unit_id')
                    ->label('Unit')
                    ->relationship('unit', 'nama'),
            ], layout: FiltersLayout::AboveContent)
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            MagangResource\Widgets\MagangOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMagangs::route('/'),
            'create' => Pages\CreateMagang::route('/create'),
            'edit' => Pages\EditMagang::route('/{record}/edit'),
        ];
    }
}
