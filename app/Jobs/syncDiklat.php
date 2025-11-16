<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class syncDiklat implements ShouldQueue
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
        $responsePelatihan = $service->getPelatihanByNik($this->token, $this->biodata_id);
        $dataPelatihan = $responsePelatihan->toArray();
        foreach ($dataPelatihan as $pelatihan) {
            Log::info('Processing pelatihan: ' . json_encode($pelatihan));
            // dapatkan pegawai id
            $pegawai = \App\Models\Pegawai::where('biodata_id', $this->biodata_id)->first();
            if (!$pegawai) {
                continue;
            }

            // cek jika judul belum ada, lewati
            if (!isset($pelatihan['judul_diklat'])) {
                continue;
            }

            // cek apakah pelatihan sudah ada
            $diklatPelatihan = \App\Models\Diklat\DiklatPelatihan::where('pegawai_id', $pegawai->id)
                ->where('judul', $pelatihan['judul_diklat'])
                ->where('penyelenggara', $pelatihan['nm_penyelenggara_diklat'])
                ->first();

            if (!$diklatPelatihan) {
                $diklatPelatihan = new \App\Models\Diklat\DiklatPelatihan();
                $diklatPelatihan->created_at = now();
            }

            $diklatPelatihan->pegawai_id = $pegawai->id;
            // dapatkan diklat jenis id
            if ($pelatihan['jenis_diklat'] == null) {
                $pelatihan['jenis_diklat'] = 'Unknown';
            }
            $diklatJenis = \App\Models\Diklat\DiklatJenis::where('nama', $pelatihan['jenis_diklat'])->first();
            if ($diklatJenis) {
                $diklatPelatihan->diklat_jenis_id = $diklatJenis->id;
            } else {
                \App\Models\Diklat\DiklatJenis::create(['nama' => $pelatihan['jenis_diklat']]);
                $diklatJenis = \App\Models\Diklat\DiklatJenis::where('nama', $pelatihan['jenis_diklat'])->first();
                $diklatPelatihan->diklat_jenis_id = $diklatJenis->id;
            }

            //dapatkan diklat kategori id
            if ($pelatihan['kategori_diklat'] == null) {
                $pelatihan['kategori_diklat'] = 'Unknown';
            }
            $diklatKategori = \App\Models\Diklat\DiklatKategori::where('nama', $pelatihan['kategori_diklat'])->first();
            if ($diklatKategori) {
                $diklatPelatihan->diklat_kategori_id = $diklatKategori->id;
            } else {
                \App\Models\Diklat\DiklatKategori::create(['nama' => $pelatihan['kategori_diklat']]);
                $diklatKategori = \App\Models\Diklat\DiklatKategori::where('nama', $pelatihan['kategori_diklat'])->first();
                $diklatPelatihan->diklat_kategori_id = $diklatKategori->id;
            }


            // dapatkan diklat metode id
            if ($pelatihan['metode_diklat'] == null) {
                $pelatihan['metode_diklat'] = 'Unknown';
            }
            $diklatMetode = \App\Models\Diklat\DiklatMetode::where('nama', str_replace('/', '-', $pelatihan['metode_diklat']))->first();
            if ($diklatMetode) {
                $diklatPelatihan->diklat_metode_id = $diklatMetode->id;
            } else {
                \App\Models\Diklat\DiklatMetode::create(['nama' => str_replace('/', '-', $pelatihan['metode_diklat'])]);
                $diklatMetode = \App\Models\Diklat\DiklatMetode::where('nama', str_replace('/', '-', $pelatihan['metode_diklat']))->first();
                $diklatPelatihan->diklat_metode_id = $diklatMetode->id;
            }

            $diklatPelatihan->judul = $pelatihan['judul_diklat'];
            $diklatPelatihan->penyelenggara = $pelatihan['nm_penyelenggara_diklat'];
            $diklatPelatihan->lokasi = $pelatihan['lokasi_diklat'];
            $diklatPelatihan->tanggal_mulai = $pelatihan['tanggal_mulai'];
            $diklatPelatihan->tanggal_selesai = $pelatihan['tanggal_selesai'];
            $diklatPelatihan->peran = $pelatihan['peran'];
            $diklatPelatihan->sumber_dana = $pelatihan['sumber_dana'];
            $diklatPelatihan->biaya = $pelatihan['nominal_biaya'];
            $diklatPelatihan->status = (isset($pelatihan['status_verifikasi'])) ? true : false;
            $diklatPelatihan->updated_at = now();

            $diklatPelatihan->save();
        }
    }
}
