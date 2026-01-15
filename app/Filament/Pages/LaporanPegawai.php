<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Filament\Forms\Form;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use App\Models\Fungsional;
use App\Models\Direktorat;
use App\Models\JenisTenaga;
use App\Models\Pegawai;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Magang;

class LaporanPegawai extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan-pegawai';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Pegawai';

    public ?array $data = []; // Untuk menyimpan data form

    public ?Collection $reportResults = null; // Untuk menyimpan hasil laporan

    protected static ?int $navigationSort = 1;

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
        // data pegawai
        $results = Pegawai::Select(
            'pegawai.id',
            'biodata.nama',
            'fungsional.nama as fungsional',
            'direktorat.nama as direktorat',
            'departemen.nama as departemen',
            'jenis_tenaga.nama as jenis_tenaga',
            'status_kepegawaian.nama as status_kepegawaian',
            'biodata.jenis_kelamin',
            'pendidikan.jenjang',
            'unit.nama as unit',
            DB::raw('coalesce(vw_rekap_pelatihan.pelatihan, 0) as total_pelatihan'),
        )
            ->join('biodata', 'pegawai.biodata_id', '=', 'biodata.id')
            ->leftjoin('fungsional', 'pegawai.fungsional_id', '=', 'fungsional.id')
            ->leftjoin('direktorat', 'pegawai.direktorat_id', '=', 'direktorat.id')
            ->leftjoin('departemen', 'pegawai.departemen_id', '=', 'departemen.id')
            ->leftjoin('jenis_tenaga', 'pegawai.jenis_tenaga_id', '=', 'jenis_tenaga.id')
            ->leftjoin('status_kepegawaian', 'pegawai.status_kepegawaian_id', '=', 'status_kepegawaian.id')
            ->leftjoin('pendidikan', 'pendidikan.biodata_id', '=', 'biodata.id')
            ->leftjoin('unit', 'pegawai.unit_id', '=', 'unit.id')
            ->leftjoin('vw_rekap_pelatihan', 'vw_rekap_pelatihan.pegawai_id', '=', 'pegawai.id')
            ->where('pegawai.is_active', 1)
            ->get()->toArray(); // Ambil data pegawai sesuai filter yang diberikan

        // data magang di gabungkan
        $magangResults = Magang::Select(
            'magang.id',
            'biodata.nama',
            // "null as fungsional",
            // 'null as direktorat',
            // 'null as departemen',
            'jenis_tenaga.nama as jenis_tenaga',
            'status_kepegawaian.nama as status_kepegawaian',
            'biodata.jenis_kelamin',
            // 'null as jenjang',
            'unit.nama as unit',
        )
            ->join('biodata', 'magang.biodata_id', '=', 'biodata.id')
            ->leftjoin('jenis_tenaga', 'magang.jenis_tenaga_id', '=', 'jenis_tenaga.id')
            ->leftjoin('status_kepegawaian', 'magang.status_kepegawaian_id', '=', 'status_kepegawaian.id')
            ->leftjoin('pendidikan', 'pendidikan.biodata_id', '=', 'biodata.id')
            ->leftjoin('unit', 'magang.unit_id', '=', 'unit.id')
            ->where('magang.is_active', 1)
            ->get()->toArray(); // Ambil data pegawai sesuai filter yang diberikan

        // Gabungkan kedua hasil
        $results = array_merge($results, $magangResults);

        // Simpan hasil ke properti untuk digunakan di view
        $this->data = $results; // Simpan hasil ke properti

    }
}
