<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Biodata;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class StatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        $user = User::find(Auth::id());

        return $user->can('view_any_pegawai');
    }

    protected function getStats(): array
    {   // Menghitung statistik pegawai
        $jumlahPegawai = Biodata::count();

        $jumlahPegawaiAktif = Biodata::join('pegawai', 'biodata.id', '=', 'pegawai.biodata_id')
            ->where('pegawai.is_active', true)
            ->count();

        // Menghitung jumlah pegawai berdasarkan jenis kelamin dan status keaktifan
        $jumlahLakiLaki = Biodata::join('pegawai', 'biodata.id', '=', 'pegawai.biodata_id')
            ->where('jenis_kelamin', 'Laki - Laki')
            ->where('pegawai.is_active', true)
            ->count();

        $jumlahPerempuan = Biodata::join('pegawai', 'biodata.id', '=', 'pegawai.biodata_id')
            ->where('jenis_kelamin', 'Perempuan')
            ->where('pegawai.is_active', true)
            ->count();

        // Menghitung rata-rata usia pegawai aktif
        $rata2Usia = Biodata::join('pegawai', 'biodata.id', '=', 'pegawai.biodata_id')
            ->where('pegawai.is_active', true)
            ->avg(DB::raw('year(NOW()) - year(biodata.tanggal_lahir)'));

        return [
            Stat::make('Total Pegawai', $jumlahPegawai . ' Orang')
                ->description('Total Pegawai')
                ->color('primary')
                ->icon('heroicon-o-users'),

            Stat::make('Laki-laki', $jumlahLakiLaki . ' Orang')
                ->description('Total pegawai laki-laki aktif')
                ->color('success')
                ->icon('heroicon-o-building-office'),

            Stat::make('Perempuan', $jumlahPerempuan . ' Orang')
                ->description('Total pegawai perempuan aktif')
                ->color('danger')
                ->icon('heroicon-o-building-office'),

            Stat::make('Pegawai Aktif', $jumlahPegawaiAktif . ' Orang')
                ->description('Total pegawai aktif')
                ->color('success')
                ->icon('heroicon-o-building-office'),

            Stat::make('Rata-Rata Usia', number_format($rata2Usia, 0) . ' Tahun')
                ->description('Rata-rata usia pegawai aktif')
                ->color('success')
                ->icon('heroicon-o-user'),
        ];
    }
}
