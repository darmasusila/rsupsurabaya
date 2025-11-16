<?php

namespace App\Filament\Pages;

use App\Models\Diklat\DiklatFellowship;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Actions;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use App\Models\Diklat\DiklatPelatihan;
use Filament\Notifications\Notification;
use Filament\Tables\Enums\FiltersLayout;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Fellowship extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.fellowship';

    protected static ?string $navigationLabel = 'Fellowship';

    protected static ?string $navigationGroup = 'Diklat';

    public static function shouldRegisterNavigation(): bool
    {
        $user = User::find(Auth::id());

        return $user->can('view_any_pegawai');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return DiklatFellowship::query();
            })
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.biodata.nama')
                    ->label('Nama Lengkap')
                    ->description(fn(DiklatFellowship $record): string => $record->pegawai->biodata->gelar_depan . ' ' . $record->pegawai->biodata->gelar_belakang)
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Pelatihan')
                    ->description(fn(DiklatFellowship $record): string => date('d-m-Y', strtotime($record->tanggal_mulai)) . ' s.d. ' . date('d-m-Y', strtotime($record->tanggal_selesai)))
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('diklatFellowshipJenis.nama')
                    ->label('Jenis Fellowship')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('status')
                    ->label('Validasi')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('diklat_fellowship_jenis_id')->label('Jenis Fellowship')->relationship('diklatFellowshipJenis', 'nama'),
                Tables\Filters\SelectFilter::make('status')->label('Status Validasi')->options([
                    1 => 'Tervalidasi',
                    0 => 'Belum Tervalidasi',
                ]),
                Tables\Filters\SelectFilter::make('unit_id')
                    ->label('Unit')
                    ->relationship('pegawai.unit', 'nama'),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                //
            ])
            ->headerActions(
                [
                    Actions\Action::make('sync')
                        ->label('Sinkronisasi Data Fellowship')
                        ->action('syncFellowship')
                        ->color('success')
                        ->icon('heroicon-o-arrow-path')
                        ->action(
                            function () {
                                \App\Http\Controllers\SyncController::syncFellowship();
                                Notification::make()
                                    ->title('Sinkronisasi Data Fellowship Berhasil Dijalankan. Mohon tunggu 10 - 15 menit untuk melihat data terbaru dengan me-refresh halaman.')
                                    ->success()
                                    ->send();
                            },
                        ),
                ]
            )
            ->bulkActions([
                //
            ]);
    }
}
