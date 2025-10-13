<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UlangtahunOverview extends Widget
{
    protected static ?int $sort = 5;
    protected static string $view = 'filament.widgets.ulangtahun-overview';
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
            'ulangtahun' => DB::Select("select concat(day(b.tanggal_lahir),'-',month(b.tanggal_lahir),'-',year(NOW())) as ulangtahun , b.nama, u.nama as unit,  'Hari Ini' as status 
            from biodata b
            join pegawai p on b.id = p.biodata_id
            join unit u on p.unit_id = u.id
            WHERE DAY(b.tanggal_lahir) = DAY(CURDATE())
            AND MONTH(b.tanggal_lahir) = MONTH(CURDATE())
            union  
            select concat(day(b.tanggal_lahir),'-',month(b.tanggal_lahir),'-',year(NOW())) as ulangtahun , b.nama, u.nama as unit, 'Minggu Ini' as status 
            from biodata b
            join pegawai p on b.id = p.biodata_id
            join unit u on p.unit_id = u.id
            WHERE
                DATE_FORMAT(b.tanggal_lahir , '%m-%d') BETWEEN
                DATE_FORMAT(CURDATE()+1 - INTERVAL WEEKDAY(CURDATE()) DAY, '%m-%d')
                AND
                DATE_FORMAT(CURDATE() + INTERVAL (6 - WEEKDAY(CURDATE())) DAY, '%m-%d')
            order by ulangtahun"),
        ];
    }
}
