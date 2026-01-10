<?php

namespace App\Filament\Resources\MagangResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Biodata;

class MagangOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // menghitung data statistik magang
            Stat::make('Jumlah Magang', Biodata::join('magang', 'biodata.id', '=', 'magang.biodata_id')
                ->where('magang.status_kepegawaian_id', 7)->count())
                ->description('Total peserta magang')
                ->color('primary')
                ->icon('heroicon-o-briefcase'),

            Stat::make('Magang Aktif', Biodata::join('magang', 'biodata.id', '=', 'magang.biodata_id')
                ->where('magang.status_kepegawaian_id', 7)
                ->where('magang.is_active', true)->count())
                ->description('Peserta magang aktif')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
