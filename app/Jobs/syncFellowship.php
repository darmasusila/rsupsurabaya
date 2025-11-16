<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class syncFellowship implements ShouldQueue
{
    use Queueable;
    private $token;
    private $biodata_id;

    /**
     * Create a new job instance.
     */
    public function __construct($token, $biodata_id)
    {
        $this->token = $token;
        $this->biodata_id = $biodata_id;
    }

    /**
     * Execute the job.
     */

    public function handle(): void
    {
        $service = new \App\Services\ApiService();
        $response = $service->getFellowshipByNik($this->token, $this->biodata_id);
        $dataFellowship = $response->toArray();
        foreach ($dataFellowship as $fellowship) {
            Log::info('Processing fellowship: ' . json_encode($fellowship));

            // dapatkan pegawai id
            $pegawai = \App\Models\Pegawai::where('biodata_id', $this->biodata_id)->first();
            if (!$pegawai) {
                continue;
            }

            // cek jika judul belum ada, lewati
            if (!isset($fellowship['judul_fellowship'])) {
                continue;
            }

            // cek apakah pelatihan sudah ada
            $diklatFellowship = \App\Models\Diklat\DiklatFellowship::where('pegawai_id', $pegawai->id)
                ->where('judul', $fellowship['judul_fellowship'])
                ->where('penyelenggara', $fellowship['nm_penyelenggara_fellowship'])
                ->first();

            if (!$diklatFellowship) {
                $diklatFellowship = new \App\Models\Diklat\DiklatFellowship();
                $diklatFellowship->created_at = now();
            }

            $diklatFellowship->pegawai_id = $pegawai->id;
            // dapatkan fellowship jenis id
            if ($fellowship['jenis_fellowship'] == null) {
                $fellowship['jenis_fellowship'] = 'Unknown';
            }
            $diklatFellowshipJenis = \App\Models\Diklat\DiklatFellowshipJenis::where('nama', $fellowship['jenis_fellowship'])->first();
            if ($diklatFellowshipJenis) {
                $diklatFellowship->diklat_fellowship_jenis_id = $diklatFellowshipJenis->id;
            } else {
                \App\Models\Diklat\DiklatFellowshipJenis::create(['nama' => $fellowship['jenis_fellowship']]);
                $diklatFellowshipJenis = \App\Models\Diklat\DiklatFellowshipJenis::where('nama', $fellowship['jenis_fellowship'])->first();
                $diklatFellowship->diklat_fellowship_jenis_id = $diklatFellowshipJenis->id;
            }

            $diklatFellowship->judul = $fellowship['judul_fellowship'];
            $diklatFellowship->penyelenggara = $fellowship['nm_penyelenggara_fellowship'];
            $diklatFellowship->lokasi = $fellowship['lokasi_fellowship'];
            $diklatFellowship->tanggal_mulai = $fellowship['tanggal_mulai'];
            $diklatFellowship->tanggal_selesai = $fellowship['tanggal_selesai'];
            $diklatFellowship->sumber_dana = $fellowship['sumber_dana'];
            $diklatFellowship->biaya = $fellowship['nominal_biaya'];
            $diklatFellowship->status = (isset($fellowship['status_verifikasi'])) ? true : false;
            $diklatFellowship->updated_at = now();

            $diklatFellowship->save();
        }
    }
}
