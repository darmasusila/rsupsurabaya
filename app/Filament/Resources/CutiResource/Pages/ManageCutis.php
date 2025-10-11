<?php

namespace App\Filament\Resources\CutiResource\Pages;

use App\Filament\Resources\CutiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Models\User;
use DateTime;

class ManageCutis extends ManageRecords
{
    protected static string $resource = CutiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajukan Cuti')
                ->mutateFormDataUsing(
                    function (array $data): array {

                        $date1 = new DateTime($data['tanggal_mulai'] ?? '');
                        $date2 = new DateTime($data['tanggal_selesai'] ?? '');
                        $lama = $date1->diff($date2)->days + 1;

                        $data['lama'] = $lama;
                        $data['pegawai_id'] = User::getPegawaiId();
                        $data['periode'] = date('Y');
                        $data['status_atasan'] = 'pending';
                        $data['status_pejabat'] = 'pending';

                        return $data;
                    }
                )
                ->before(function (array $data): array {

                    $plafon = \App\Models\PlafonCuti::where('pegawai_id', User::getPegawaiId())->first()->jumlah_hari ?? 0;
                    $ambil = \App\Models\Cuti::where('pegawai_id', User::getPegawaiId())->whereIn('status_atasan', ['approved'])->count();
                    $sisa = $plafon - $ambil;

                    if ($data['lama'] > $sisa) {
                        throw new \Exception('Jumlah hari cuti melebihi sisa cuti Anda.');
                    }
                    return $data;
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CutiResource\Widgets\CutiOverview::class,
        ];
    }
}
