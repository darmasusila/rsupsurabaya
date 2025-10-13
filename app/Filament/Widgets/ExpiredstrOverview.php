<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ExpiredstrOverview extends Widget
{
    protected static string $view = 'filament.widgets.expiredstr-overview';
    protected static ?int $sort = 6;
    public ?array $data = []; // Untuk menyimpan data form
    // protected int | string | array $columnSpan = 'full';
    public ?bool $visible = null;

    public function mount()
    {
        // Inisialisasi data atau logika lainnya jika diperlukan
        $user = User::find(Auth::id());
        $this->visible = $user ? $user->can('view_any_pegawai') : false;
        $this->data = [
            // Inisialisasi data atau logika lainnya jika diperlukan
            'expired_str' => DB::Select("select p.nip, b.nama, p.no_sip , p.tanggal_akhir_berlaku, u.nama as unit, 'expired' as status 
            from pegawai p 
            join biodata b on p.biodata_id = b.id
            join unit u on p.unit_id = u.id
            where p.no_sip is not null and p.tanggal_akhir_berlaku < now()
            union
            select p.nip, b.nama, p.no_sip , p.tanggal_akhir_berlaku, u.nama as unit, 'akan berakhir < 3 bulan' as status 
            from pegawai p
            join biodata b on p.biodata_id = b.id
            join unit u on p.unit_id = u.id
            where p.no_sip is not null
            and DATE_FORMAT(p.tanggal_akhir_berlaku , '%y-%m-%d') BETWEEN
                DATE_FORMAT(CURDATE() - INTERVAL WEEKDAY(CURDATE()) MONTH, '%y-%m-%d')
                AND
                DATE_FORMAT(CURDATE() + INTERVAL (3 - WEEKDAY(CURDATE())) MONTH, '%y-%m-%d')"),
        ];
    }
}
