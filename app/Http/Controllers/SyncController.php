<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
            $statusKepegawaian = \App\Models\StatusKepegawaian::where('nama', $dataCoba->STATUS)->first();
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

            // departemen
            $departemen = \App\Models\Departemen::where('nama', $dataCoba->DEPARTEMEN)->first();
            if ($departemen) {
                $pegawai->departemen_id = $departemen->id;
            } else {
                $pegawai->departemen_id = null;
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
            $pegawai->nip = $dataCoba->NIP ? $dataCoba->NIP : $dataCoba->NIP_NON_PNS;
            $pegawai->tingkat_ahli = $dataCoba->JENJANG_JABFUNG ? $dataCoba->JENJANG_JABFUNG : null;
            $pegawai->jenjang_jabatan = $dataCoba->JENJANG_JABFUNG ? $dataCoba->JENJANG_JABFUNG : null;
            $pegawai->kelas_jabatan = $dataCoba->KELAS;
            $pegawai->golongan = $dataCoba->GOL ? $dataCoba->GOL : null;
            $pegawai->no_sk = $dataCoba->NOMOR_SK_KP ? $dataCoba->NOMOR_SK_KP : null;
            $pegawai->no_str = $dataCoba->STR ? $dataCoba->STR : null;
            $pegawai->no_sip = $dataCoba->SIP ? $dataCoba->SIP : null;
            // if (strlen($dataCoba->TMT_GOL) > 9) {
            //     $pegawai->tmt_golongan = $dataCoba->TMT_GOL ?? null;
            // }
            $pegawai->tanggal_akhir_berlaku = date('Y-m-d', strtotime($dataCoba->SIP_BERAKHIR ?? null));
            $pegawai->kewenangan_klinis = $dataCoba->KEWENANGAN_KLINIS ?? null;
            $pegawai->is_active = true;
            $pegawai->no_npwp = $dataCoba->NPWP ?? null;
            $pegawai->no_taspen = $dataCoba->TASPEN ?? null;
            $pegawai->instansi_sebelumnya = $dataCoba->INSTANSI_SEBELUMNYA ?? null;
            $pegawai->created_at = now();
            $pegawai->updated_at = now();
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
            if ($dataCoba->JENJANG_PENDIDIKAN_TERAKHIR != null) {
                $pendidikan->biodata_id = $data->id;
                $pendidikan->jenjang = $dataCoba->JENJANG_PENDIDIKAN_TERAKHIR ?? null;
                $pendidikan->program_studi = $dataCoba->PENDIDIKAN ?? null;
                $pendidikan->institusi = $dataCoba->UNIV ?? null;
                $pendidikan->tanggal_lulus = null;
                $pendidikan->institusi_spesialis = $dataCoba->UNIV_SPESIALIS ?? null;
                $pendidikan->institusi_subspesialis = $dataCoba->UNIV_SUBSPESIALIS ?? null;
                $pendidikan->no_ijasah = $dataCoba->NO_IJASAH ?? null;
                $pendidikan->no_ijasah_subspesialis = $dataCoba->NO_IJASAH_SUBSPESIALIS ?? null;
                $pendidikan->no_ijasah_spesialis = $dataCoba->NO_IJASAH_SPESIALIS ?? null;
                $pendidikan->keterangan = 'Tahun : ' . ($dataCoba->TAHUN ?? null);

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

    public static function syncPlafonCuti()
    {
        $pegawai = \App\Models\Pegawai::where('is_active', true)->get();

        foreach ($pegawai as $data) {
            // cari plafon cuti
            $plafonCuti = \App\Models\PlafonCuti::where('pegawai_id', $data->id)
                ->where('jenis_cuti', 'Cuti Tahunan')
                ->where('periode', date('Y'))
                ->first();

            if (!$plafonCuti) {
                $plafonCuti = new \App\Models\PlafonCuti();
                $plafonCuti->pegawai_id = $data->id;
                $plafonCuti->jenis_cuti = 'Cuti Tahunan';
                $plafonCuti->periode = date('Y');
                $plafonCuti->jumlah_hari = 12; // default 12 hari
                $plafonCuti->created_at = now();
                $plafonCuti->save();
            }
        }

        return response()->json(['message' => 'Plafon cuti sync successfully']);
    }

    public static function syncProfesi()
    {
        // cek apakah data pegawai sudah ada
        $isExist = \App\Models\Pegawai::first();
        if ($isExist) {
            return;
        }

        // drop dulu semua data direktorat, karena ada relasi harus di disable dulu
        Schema::disableForeignKeyConstraints();
        // drop dulu semua data fungsional
        \App\Models\Fungsional::truncate();
        Schema::enableForeignKeyConstraints();

        // ambil data profesi dari data coba
        $dataCoba = \App\Models\DataCoba::select('PROFESI')
            ->distinct()
            ->whereNotNull('PROFESI')
            ->get();

        foreach ($dataCoba as $data) {
            // cek apakah sudah ada di tabel fungsional
            $fungsional = \App\Models\Fungsional::where('nama', $data->PROFESI)->first();
            if (!$fungsional) {
                $fungsional = new \App\Models\Fungsional();
                $fungsional->nama = $data->PROFESI;
                $fungsional->is_str = false;
                $fungsional->save();
            }
        }
    }

    public static function syncStatus()
    {
        // cek apakah data pegawai sudah ada
        $isExist = \App\Models\Pegawai::first();
        if ($isExist) {
            return;
        }

        // drop dulu semua data direktorat, karena ada relasi harus di disable dulu
        Schema::disableForeignKeyConstraints();
        // drop dulu semua data status kepegawaian
        \App\Models\StatusKepegawaian::truncate();
        Schema::enableForeignKeyConstraints();

        // ambil data status dari data coba
        $dataCoba = \App\Models\DataCoba::select('STATUS')
            ->distinct()
            ->whereNotNull('STATUS')
            ->get();

        foreach ($dataCoba as $data) {
            // cek apakah sudah ada di tabel status kepegawaian
            $statusKepegawaian = \App\Models\StatusKepegawaian::where('nama', $data->STATUS)->first();
            if (!$statusKepegawaian) {
                $statusKepegawaian = new \App\Models\StatusKepegawaian();
                $statusKepegawaian->nama = $data->STATUS;
                $statusKepegawaian->save();
            }
        }
    }

    public static function syncStruktural()
    {
        // cek apakah data pegawai sudah ada
        $isExist = \App\Models\Pegawai::first();
        if ($isExist) {
            return;
        }

        // drop dulu semua data direktorat, karena ada relasi harus di disable dulu
        Schema::disableForeignKeyConstraints();
        // drop dulu semua data struktural
        \App\Models\Struktural::truncate();
        Schema::enableForeignKeyConstraints();

        // ambil data struktural dari data coba
        $dataCoba = \App\Models\DataCoba::select('JABATAN')
            ->distinct()
            ->whereRaw('LENGTH(JABATAN)>10')
            ->get();

        foreach ($dataCoba as $data) {
            // cek apakah sudah ada di tabel struktural
            $struktural = \App\Models\Struktural::where('nama', $data->JABATAN)->first();
            if (!$struktural) {
                $struktural = new \App\Models\Struktural();
                $struktural->nama = $data->JABATAN;
                $struktural->keterangan = 'Struktural';
                $struktural->save();
            }
        }
    }

    public static function syncDirektorat()
    {
        // cek apakah data pegawai sudah ada
        $isExist = \App\Models\Pegawai::first();
        if ($isExist) {
            return;
        }

        // drop dulu semua data direktorat, karena ada relasi harus di disable dulu
        Schema::disableForeignKeyConstraints();
        \App\Models\Direktorat::truncate();
        Schema::enableForeignKeyConstraints();

        // ambil data direktorat dari data coba
        $dataCoba = \App\Models\DataCoba::select('DIREKTORAT', 'JABATAN')
            ->distinct()
            ->whereNotNull('DIREKTORAT')
            ->whereRaw('LENGTH(JABATAN)>5')
            // kecuali jabatan yang mengandung kata dokter
            ->whereRaw('JABATAN LIKE "Direktur%" or JABATAN like "Direktorat%"')
            ->get();

        foreach ($dataCoba as $data) {
            // cek apakah sudah ada di tabel direktorat
            $direktorat = \App\Models\Direktorat::where('nama', $data->DIREKTORAT)->first();
            if (!$direktorat) {
                $direktorat = new \App\Models\Direktorat();

                // dapatkan id struktural dari jabatan direktur
                $struktural = \App\Models\Struktural::where('nama', $data->JABATAN)->first();
                if ($struktural) {
                    $direktorat->struktural_id = $struktural->id;
                }

                $direktorat->nama = strtoupper($data->DIREKTORAT);
                $direktorat->save();
            }
        }
    }

    public static function syncDepartemen()
    {
        // cek apakah data pegawai sudah ada
        $isExist = \App\Models\Pegawai::first();
        if ($isExist) {
            return;
        }

        // drop dulu semua data departemen, karena ada relasi harus di disable dulu
        Schema::disableForeignKeyConstraints();
        \App\Models\Departemen::truncate();
        Schema::enableForeignKeyConstraints();

        // ambil data departemen dari data coba
        $dataCoba = \App\Models\DataCoba::select('DEPARTEMEN', 'DIREKTORAT')
            ->distinct()
            ->where('DEPARTEMEN', '!=', '')
            ->get();

        foreach ($dataCoba as $data) {
            // cek apakah sudah ada di tabel departemen
            $departemen = \App\Models\Departemen::where('nama', $data->DEPARTEMEN)->first();
            if (!$departemen) {
                // cek direktoratnya ada atau tidak
                $direktorat = \App\Models\Direktorat::where('nama', $data->DIREKTORAT)->first();
                if (!$direktorat) {
                    continue;
                }
                $departemen = new \App\Models\Departemen();
                $departemen->nama = $data->DEPARTEMEN;
                $departemen->direktorat_id = $direktorat->id;
                $departemen->save();
            }
        }
    }

    public static function syncUnit()
    {
        // cek apakah data pegawai sudah ada
        $isExist = \App\Models\Pegawai::first();
        if ($isExist) {
            return;
        }

        // drop dulu semua data unit, karena ada relasi harus di disable dulu
        Schema::disableForeignKeyConstraints();
        \App\Models\Unit::truncate();
        Schema::enableForeignKeyConstraints();

        // ambil data unit dari data coba
        $dataCoba = \App\Models\DataCoba::select('UNIT_KERJA', 'DIREKTORAT', 'DEPARTEMEN', 'JABATAN')
            ->distinct()
            ->where('UNIT_KERJA', '!=', '')
            ->get();

        foreach ($dataCoba as $data) {
            // cek apakah sudah ada di tabel unit
            $unit = \App\Models\Unit::where('nama', $data->UNIT_KERJA)->first();
            if (!$unit) {
                $unit = new \App\Models\Unit();
                $unit->nama = $data->UNIT_KERJA;
                $unit->keterangan = null;

                // dapatkan direktorat id
                $direktorat = \App\Models\Direktorat::where('nama', $data->DIREKTORAT)->first();
                if ($direktorat) {
                    $unit->direktorat_id = $direktorat->id;
                } else {
                    $unit->direktorat_id = null;
                }

                // dapatkan departemen id
                $departemen = \App\Models\Departemen::where('nama', $data->DEPARTEMEN)->first();
                if ($departemen) {
                    $unit->departemen_id = $departemen->id;
                } else {
                    $unit->departemen_id = null;
                }

                $unit->struktural_id = null;
                $unit->created_at = now();
                $unit->updated_at = now();
                $unit->save();
            }
        }
    }
}
