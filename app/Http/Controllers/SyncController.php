<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SyncController extends Controller
{
    public static function syncPegawai()
    {
        $biodata = \App\Models\Biodata::all();

        foreach ($biodata as $data) {
            $pegawai = \App\Models\Pegawai::where('biodata_id', $data->id)->first();

            if (!$pegawai) {
                $pegawai = new \App\Models\Pegawai();
            }

            // ambil data dari data coba
            $dataCoba = \App\Models\DataCoba::where('NAMA', $data->nama)->where('NO_KTP', $data->nik)->first();

            // data fungsional
            $fungsional = \App\Models\Fungsional::where('nama', $dataCoba->PROFESI)->first();
            if ($fungsional) {
                $pegawai->fungsional_id = $fungsional->id;
            } else {
                // tambahkan data fungsional
                $fungsional = new \App\Models\Fungsional();
                $fungsional->nama = $dataCoba->PROFESI;
                $fungsional->save();

                $pegawai->fungsional_id = $fungsional->id;
            }

            // jenis tenaga
            $jenisTenaga = \App\Models\JenisTenaga::where('nama', $dataCoba->JENIS_TENAGA)->first();
            if ($jenisTenaga) {
                $pegawai->jenis_tenaga_id = $jenisTenaga->id;
            } else {
                $pegawai->jenis_tenaga_id = null;
            }

            // status kepegawaian
            $statusKepegawaian = \App\Models\StatusKepegawaian::where('nama', $dataCoba->STATUS_PEGAWAI)->first();
            if ($statusKepegawaian) {
                $pegawai->status_kepegawaian_id = $statusKepegawaian->id;
            } else {
                $pegawai->status_kepegawaian_id = null;
            }

            // direktorat
            $direktorat = \App\Models\Direktorat::where('nama', $dataCoba->DIREKTORAT)->first();
            if ($direktorat) {
                $pegawai->direktorat_id = $direktorat->id;
            } else {
                $pegawai->direktorat_id = null;
            }

            // struktur organisasi
            $strukturOrganisasi = \App\Models\Struktural::where('nama', $dataCoba->JABATAN)->first();
            if ($strukturOrganisasi) {
                $pegawai->struktural_id = $strukturOrganisasi->id;
            } else {
                $pegawai->struktural_id = null;
            }

            // unit kerja
            if ($dataCoba->UNIT_KERJA) {
                $unitKerja = \App\Models\Unit::where('nama', $dataCoba->UNIT_KERJA)->first();
                if ($unitKerja) {
                    $pegawai->unit_id = $unitKerja->id;
                } else {
                    $unitKerja = new \App\Models\Unit();
                    $unitKerja->nama = $dataCoba->UNIT_KERJA;
                    $unitKerja->keterangan = null;
                    $unitKerja->direktorat_id = $pegawai->direktorat_id;
                    $unitKerja->created_at = now();
                    $unitKerja->updated_at = now();
                    $unitKerja->save();

                    $pegawai->unit_id = $unitKerja->id;
                }
            } else {
                $pegawai->unit_id = null;
            }

            $pegawai->biodata_id = $data->id;
            $pegawai->nip = $dataCoba ? $dataCoba->NIP : null;
            $pegawai->tingkat_ahli = $dataCoba->AHLI;
            $pegawai->kelas_jabatan = $dataCoba->KELAS;
            $pegawai->golongan = $dataCoba ? $dataCoba->GOL : null;
            $pegawai->no_sk = $dataCoba ? $dataCoba->NOMOR_SK_KP : null;
            $pegawai->no_str = $dataCoba ? $dataCoba->STR : null;
            $pegawai->no_sip = $dataCoba ? $dataCoba->SIP : null;
            // if (strlen($dataCoba->TMT_GOL) > 9) {
            //     $pegawai->tmt_golongan = $dataCoba->TMT_GOL ?? null;
            // }
            // $pegawai->tanggal_akhir_berlaku = $dataCoba->BERLAKU_SIP ?? null;
            // Add other fields as necessary

            $pegawai->save();
        }

        // Sync pendidikan
        self::syncPendidikan();

        return response()->json(['message' => 'Pegawai data synced successfully']);
    }

    public static function syncPendidikan()
    {
        $biodata = \App\Models\Biodata::all();

        foreach ($biodata as $data) {
            // ambil data dari data coba
            $dataCoba = \App\Models\DataCoba::where('NO_KTP', $data->nik)->first();

            $pendidikan = \App\Models\Pendidikan::where('biodata_id', $data->id)->first();

            if (!$pendidikan) {
                $pendidikan = new \App\Models\Pendidikan();
            }

            // pendidikan
            if ($dataCoba->JENJANG != null) {
                $pendidikan->biodata_id = $data->id;
                $pendidikan->jenjang = $dataCoba ? $dataCoba->JENJANG : null;
                $pendidikan->program_studi = $dataCoba ? $dataCoba->PENDIDIKAN : null;
                $pendidikan->institusi = $dataCoba ? $dataCoba->UNIV_PROFESI : null;
                $pendidikan->tanggal_lulus = null;
                $pendidikan->keterangan = $dataCoba ? 'TAHUN : ' . $dataCoba->TAHUN : null;

                $pendidikan->save();
            }
        }

        return response()->json(['message' => 'Pendidikan data synced successfully']);
    }

    public static function syncUserAkses()
    {
        $biodata = \App\Models\Biodata::join('pegawai', 'pegawai.biodata_id', '=', 'biodata.id')
            ->select('biodata.*', 'pegawai.id as pegawai_id')
            ->where('biodata.email', '!=', null)
            ->where('pegawai.is_active', true)
            ->get();

        foreach ($biodata as $data) {
            // cari user apakah sudah ada
            $user = \App\Models\User::where('email', $data->email)->first();

            if (!$user) {
                $user = new \App\Models\User();
                $user->name = $data->nama;
                $user->email = $data->email;
                $user->email_verified_at = now(); // Set verified to true
                $user->password = bcrypt('password'); // Set a default password
                $user->save();
            }

            // isikan default role
            $user->assignRole('User');
        }

        return response()->json(['message' => 'User akses sync successfully']);
    }
}
