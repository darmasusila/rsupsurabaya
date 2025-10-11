<?php

namespace App\Filament\Clusters\Cutis\Resources;

use App\Filament\Clusters\Cutis;
use App\Filament\Clusters\Cutis\Resources\PersetujuanCutiResource\Pages;
use App\Filament\Clusters\Cutis\Resources\PersetujuanCutiResource\RelationManagers;
use App\Models\PersetujuanCuti;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class PersetujuanCutiResource extends Resource
{
    protected static ?string $model = PersetujuanCuti::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Cutis::class;

    protected static ?string $navigationLabel = 'Persetujuan Cuti';

    protected static ?string $pluralLabel = 'Persetujuan Cuti';

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
            ->modifyQueryUsing(
                function (Builder $query) {
                    $query->where('periode', date('Y'))
                        ->orWhere('status_atasan', 'pending')
                        ->orWhere('status_pejabat', 'pending');
                    return $query;
                }
            )
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.biodata.nama')
                    ->label('Pegawai')
                    ->description(fn($record) => $record->tanggal_mulai . ' s/d ' . $record->tanggal_selesai),
                Tables\Columns\TextColumn::make('alasan')
                    ->label('Alasan'),
                Tables\Columns\SelectColumn::make('status_atasan')
                    ->label('Atasan Langsung')
                    ->options([
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                    ]),
                Tables\Columns\SelectColumn::make('status_pejabat')
                    ->label('Pejabat Berwenang')
                    ->options([
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                    ]),
            ])
            ->filters([
                SelectFilter::make('periode')
                    ->label('Periode Cuti')
                    ->default(date('Y'))
                    ->options([
                        date('Y') => date('Y'),
                        date('Y') - 1 => date('Y') - 1,
                        date('Y') - 2 => date('Y') - 2,
                    ]),
                SelectFilter::make('status_atasan')
                    ->label('Status Atasan Langsung')
                    ->options([
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                    ])
                    ->default('pending'),
                SelectFilter::make('status_pejabat')
                    ->label('Status Pejabat Berwenang')
                    ->options([
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                    ])
                    ->default('pending'),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePersetujuanCutis::route('/'),
        ];
    }
}
