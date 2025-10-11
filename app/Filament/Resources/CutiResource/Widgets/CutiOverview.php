<?php

namespace App\Filament\Resources\CutiResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CutiOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $plafon = \App\Models\PlafonCuti::where('pegawai_id', \App\Models\User::getPegawaiId())->first()->jumlah_hari ?? 0;
        $ambil = \App\Models\Cuti::where('pegawai_id', \App\Models\User::getPegawaiId())->whereIn('status_atasan', ['approved'])->count();
        $sisa = $plafon - $ambil;
        return [
            Stat::make('Tahun', date('Y'))->color('success'),
            Stat::make('Total Cuti', $plafon)->color('info'),
            Stat::make('Cuti Diambil', $ambil)->color('warning'),
            Stat::make('Sisa Cuti', $sisa)->color('danger'),
        ];
    }
}
