<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CutiResource\Pages;
use App\Filament\Resources\CutiResource\RelationManagers;
use App\Models\Cuti;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\Section;
use App\Filament\Clusters\Cutis;

class CutiResource extends Resource
{
    protected static ?string $model = Cuti::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pengajuan Cuti';

    protected static ?string $pluralLabel = 'Pengajuan Cuti';

    protected static ?string $cluster = Cutis::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Cuti')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('jenis_cuti')
                            ->label('Jenis Cuti')
                            ->options([
                                'Cuti Tahunan' => 'Cuti Tahunan',
                                'Cuti Besar' => 'Cuti Besar',
                                'Cuti Sakit' => 'Cuti Sakit',
                                'Cuti Melahirkan' => 'Cuti Melahirkan',
                                'Cuti Karena Alasan Penting' => 'Cuti Karena Alasan Penting',
                            ])
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_mulai')
                            ->label('Tanggal Mulai')
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai')
                            ->required(),
                        Forms\Components\Textarea::make('alasan')
                            ->label('Alasan')
                            ->columnSpanFull()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                function (Builder $query) {
                    if (!\App\Models\User::getUserHasRole('admin')) {
                        // get pegawai_id from user model
                        $pegawai_id = \App\Models\User::getPegawaiId();

                        if ($pegawai_id) {
                            $query->where('pegawai_id', $pegawai_id)->where('periode', date('Y'));
                        }
                    } else {
                        $query->where('periode', date('Y'));
                    }
                }
            )
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.biodata.nama')
                    ->label('Pegawai')
                    ->description(fn($record) => $record->tanggal_mulai . ' s/d ' . $record->tanggal_selesai),
                Tables\Columns\TextColumn::make('periode')
                    ->label('Periode'),
                Tables\Columns\TextColumn::make('status_atasan')
                    ->visible(
                        fn(): bool => \App\Models\User::getUserHasRole('user')
                    )
                    ->label('Atasan Langsung'),
                Tables\Columns\TextColumn::make('status_pejabat')
                    ->visible(
                        fn(): bool => \App\Models\User::getUserHasRole('user')
                    )
                    ->label('Pejabat Berwenang'),
                Tables\Columns\SelectColumn::make('status_atasan_app')
                    ->label('Atasan Langsung')
                    ->visible(
                        fn(): bool => \App\Models\User::getUserHasRole('admin')
                    )
                    ->options([
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                    ]),
                Tables\Columns\SelectColumn::make('status_pejabat_app')
                    ->label('Pejabat Berwenang')
                    ->visible(
                        fn(): bool => \App\Models\User::getUserHasRole('admin')
                    )
                    ->options([
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                    ]),
            ])
            ->filters([
                SelectFilter::make('status_atasan')
                    ->label('Status Atasan Langsung')
                    ->options([
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                    ])
                    ->visible(
                        fn(): bool => \App\Models\User::getUserHasRole('admin')
                    ),
                SelectFilter::make('status_pejabat')
                    ->label('Status Pejabat Berwenang')
                    ->options([
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                    ])
                    ->visible(
                        fn(): bool => \App\Models\User::getUserHasRole('admin')
                    ),
                SelectFilter::make('status_atasan_app')
                    ->label('Status Atasan Langsung')
                    ->options([
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                    ])
                    ->visible(
                        fn(): bool => \App\Models\User::getUserHasRole('admin')
                    ),
                SelectFilter::make('status_pejabat_app')
                    ->label('Status Pejabat Berwenang')
                    ->options([
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                    ])
                    ->visible(
                        fn(): bool => \App\Models\User::getUserHasRole('admin')
                    ),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->visible(fn(): bool => \App\Models\User::getUserHasRole('admin')),
                Tables\Actions\Action::make('cetak')
                    ->label('Cetak')
                    ->url(fn(Cuti $record): string => route('cuti.cetak', ['id' => $record->id]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document-text'),

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
            'index' => Pages\ManageCutis::route('/'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CutiResource\Widgets\CutiOverview::class,
        ];
    }
}
