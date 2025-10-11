<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlafonCutiResource\Pages;
use App\Filament\Resources\PlafonCutiResource\RelationManagers;
use App\Models\PlafonCuti;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Cutis;

class PlafonCutiResource extends Resource
{
    protected static ?string $model = PlafonCuti::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Plafon Cuti';

    protected static ?string $pluralLabel = 'Plafon Cuti';

    protected static ?string $cluster = Cutis::class;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.biodata.nama')
                    ->description(fn($record) => $record->pegawai->biodata->gelar_depan . ' ' . $record->pegawai->biodata->gelar_belakang)
                    ->label('Nama Pegawai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_cuti')
                    ->label('Jenis Cuti'),
                Tables\Columns\TextColumn::make('periode')
                    ->label('Periode Cuti'),
                Tables\Columns\TextColumn::make('jumlah_hari')
                    ->label('Jumlah Hari'),
            ])
            ->filters([
                SelectFilter::make('jenis_cuti')
                    ->label('Jenis Cuti')
                    ->options([
                        'Cuti Tahunan' => 'Cuti Tahunan',
                        'Cuti Besar' => 'Cuti Besar',
                    ]),
                SelectFilter::make('periode')
                    ->label('Periode Cuti')
                    ->default(date('Y'))
                    ->options([
                        date('Y') => date('Y'),
                        date('Y', strtotime('-1 year')) => date('Y', strtotime('-1 year')),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlafonCutis::route('/'),
            'create' => Pages\CreatePlafonCuti::route('/create'),
            'edit' => Pages\EditPlafonCuti::route('/{record}/edit'),
        ];
    }
}
