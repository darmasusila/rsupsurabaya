<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class NilaiPegawaiWidget extends Widget
{
    protected static ?int $sort = 4;
    protected static string $view = 'filament.widgets.nilai-pegawai-widget';
    public ?array $data = []; // Untuk menyimpan data form
    protected int | string | array $columnSpan = 'full';
    public ?bool $visible = null;

    public function mount()
    {
        // Inisialisasi data atau logika lainnya jika diperlukan
        $user = User::find(Auth::id());
        $this->visible = $user ? $user->can('view_any_pegawai') : false;
        $this->data = [
            // Inisialisasi data atau logika lainnya jika diperlukan
            'rekap_jenistenaga' => DB::Select("select jt.urutan, jt.nama, count(*) as jumlah
            from pegawai p
            join jenis_tenaga jt on p.jenis_tenaga_id = jt.id 
            where p.is_active = 1
            group by jt.urutan, jt.nama
            order by jt.urutan asc"),
            'rekap_statuspegawai' => DB::Select("select sk.nama, count(*) as jumlah
            from pegawai p
            join status_kepegawaian sk on p.status_kepegawaian_id  = sk.id 
            where p.is_active = 1
            group by sk.nama
            "),
            'rekap_direktorat' => DB::Select("select d.urutan, d.nama, count(*) as jumlah
            from pegawai p
            join direktorat d on p.direktorat_id  = d.id
            where p.is_active = 1
            group by d.urutan, d.nama
            order by d.urutan asc"),
            'rekap_jenjangpendidikan' => DB::Select("select p2.jenjang, count(*) as jumlah
            from biodata b 
            join pegawai p on b.id = p.biodata_id
            join pendidikan p2 on p2.biodata_id = b.id
            where p.is_active = 1
            group by p2.jenjang
            "),
        ];
    }
}
