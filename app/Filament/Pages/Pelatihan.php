<?php

namespace App\Filament\Pages;

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

class Pelatihan extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.pelatihan';

    protected static ?string $navigationLabel = 'Pelatihan';

    protected static ?string $navigationGroup = 'Diklat';

    public static function shouldRegisterNavigation(): bool
    {
        $user = User::find(Auth::id());

        return $user->can('view_any_pegawai');
    }

    public function mount(): void {}

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return DiklatPelatihan::query();
            })
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.biodata.nama')
                    ->label('Nama Lengkap')
                    ->description(fn(DiklatPelatihan $record): string => $record->pegawai->biodata->gelar_depan . ' ' . $record->pegawai->biodata->gelar_belakang)
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Pelatihan')
                    ->description(fn(DiklatPelatihan $record): string => date('d-m-Y', strtotime($record->tanggal_mulai)) . ' s.d. ' . date('d-m-Y', strtotime($record->tanggal_selesai)))
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('diklatJenis.nama')
                    ->label('Jenis Pelatihan')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('diklatMetode.nama')
                    ->label('Metode Pelatihan')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('diklatKategori.nama')
                    ->label('Kategori Pelatihan')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('peran')
                    ->label('Peran')
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
                Tables\Filters\SelectFilter::make('diklat_jenis_id')->label('Jenis Pelatihan')->relationship('diklatJenis', 'nama'),
                Tables\Filters\SelectFilter::make('diklat_kategori_id')->label('Kategori Pelatihan')->relationship('diklatKategori', 'nama'),
                Tables\Filters\SelectFilter::make('diklat_metode_id')->label('Metode Pelatihan')->relationship('diklatMetode', 'nama'),
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
                        ->label('Sync Data Pelatihan')
                        ->color('success')
                        ->icon('heroicon-o-arrow-path')
                        ->action(
                            function () {
                                \App\Http\Controllers\SyncController::syncPelatihan();
                                Notification::make()
                                    ->title('Sinkronisasi Data Pelatihan Berhasil Dijalankan. Mohon tunggu 10 - 15 menit untuk melihat data terbaru dengan me-refresh halaman.')
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
