<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\Magang;

class LaporanMagang extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan-magang';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Magang';

    protected static ?int $navigationSort = 2;

    public ?array $data = []; // Untuk menyimpan data form

    public ?Collection $reportResults = null; // Untuk menyimpan hasil laporan

    public static function shouldRegisterNavigation(): bool
    {
        $user = User::find(Auth::id());

        return $user->can('view_any_pegawai');
    }

    public function mount(): void
    {
        $this->generateReport(); // Panggil generateReport saat halaman dimuat
    }



    public function generateReport(): void
    {
        // Lakukan query untuk mendapatkan data pegawai berdasarkan filter

        $results = Magang::Select(
            'magang.id',
            'biodata.nama',
            'jenis_tenaga.nama as jenis_tenaga',
            'status_kepegawaian.nama as status_kepegawaian',
            'biodata.jenis_kelamin',
            'unit.nama as unit',
            'magang.instansi',
            'magang.posisi',
            'magang.penempatan',
        )
            ->join('biodata', 'magang.biodata_id', '=', 'biodata.id')
            ->leftjoin('jenis_tenaga', 'magang.jenis_tenaga_id', '=', 'jenis_tenaga.id')
            ->leftjoin('status_kepegawaian', 'magang.status_kepegawaian_id', '=', 'status_kepegawaian.id')
            ->leftjoin('pendidikan', 'pendidikan.biodata_id', '=', 'biodata.id')
            ->leftjoin('unit', 'magang.unit_id', '=', 'unit.id')
            ->where('magang.is_active', 1)
            ->get()->toArray(); // Ambil data pegawai sesuai filter yang diberikan


        // Simpan hasil ke properti untuk digunakan di view
        $this->data = $results; // Simpan hasil ke properti

    }
}
