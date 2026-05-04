<?php

namespace App\Filament\Resources\DokumenKepegawaianResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class DokumenReminder extends BaseWidget
{

    // buat tampilan table ukuran full width untuk menampilkan dokumen kepegawaian yang akan kadaluarsa sesuai dengan durasi reminder yang ditentukan pada jenis dokumen
    protected int|string|array $columnSpan = 12;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // query untuk menampilkan dokumen kepegawaian yang akan kadaluarsa sesuai dengan durasi reminder yang ditentukan pada jenis dokumen
                \App\Models\DokumenKepegawaian::whereHas('jenisDokumen', function ($query) {
                    $query->whereRaw('DATEDIFF(tanggal_berakhir, NOW()) <= durasi_reminder');
                })
            )
            ->columns([
                Tables\Columns\TextColumn::make('jenisDokumen.nama_jenis_dokumen')->label('Jenis Dokumen'),
                Tables\Columns\TextColumn::make('nomor_dokumen')->label('Nomor Dokumen')
                    ->description(fn($record) => 'Pegawai: ' . $record->pegawai->biodata->nama),
                Tables\Columns\TextColumn::make('tanggal_berakhir')->label('Tanggal Berakhir')->date(),
                Tables\Columns\TextColumn::make('sisa_waktu')->label('Sisa Waktu'),
            ])
            ->defaultSort('tanggal_berakhir', 'asc');
    }
}
