<?php

namespace App\Filament\Pages;

use App\Models\Diklat\DiklatPelatihan;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class LaporanPelatihan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan-pelatihan';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Pelatihan';

    protected static ?int $navigationSort = 4;

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

        $results = DiklatPelatihan::Select(
            'diklat_pelatihan.id',
            'biodata.nama',
            'jenis_tenaga.nama as jenis_tenaga',
            'status_kepegawaian.nama as status_kepegawaian',
            'biodata.jenis_kelamin',
            'unit.nama as unit',
            'diklat_jenis.nama as diklat_jenis',
            'diklat_kategori.nama as diklat_kategori',
            'diklat_metode.nama as diklat_metode',
        )
            ->join('pegawai', 'diklat_pelatihan.pegawai_id', '=', 'pegawai.id')
            ->join('biodata', 'pegawai.biodata_id', '=', 'biodata.id')
            ->leftjoin('jenis_tenaga', 'pegawai.jenis_tenaga_id', '=', 'jenis_tenaga.id')
            ->leftjoin('status_kepegawaian', 'pegawai.status_kepegawaian_id', '=', 'status_kepegawaian.id')
            ->leftjoin('unit', 'pegawai.unit_id', '=', 'unit.id')
            ->leftjoin('diklat_jenis', 'diklat_pelatihan.diklat_jenis_id', '=', 'diklat_jenis.id')
            ->leftjoin('diklat_kategori', 'diklat_pelatihan.diklat_kategori_id', '=', 'diklat_kategori.id')
            ->leftjoin('diklat_metode', 'diklat_pelatihan.diklat_metode_id', '=', 'diklat_metode.id')
            ->get()->toArray(); // Ambil data pegawai sesuai filter yang diberikan


        // Simpan hasil ke properti untuk digunakan di view
        $this->data = $results; // Simpan hasil ke properti

    }
}
