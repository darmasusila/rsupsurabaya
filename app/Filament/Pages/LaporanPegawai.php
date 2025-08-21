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

class LaporanPegawai extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan-pegawai';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Pegawai';

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

        $results = Pegawai::Select(
            'pegawai.id',
            'biodata.nama',
            'fungsional.nama as fungsional',
            'direktorat.nama as direktorat',
            'jenis_tenaga.nama as jenis_tenaga',
            'status_kepegawaian.nama as status_kepegawaian',
            'biodata.jenis_kelamin',
            'pendidikan.jenjang',
            'unit.nama as unit',
        )
            ->join('biodata', 'pegawai.biodata_id', '=', 'biodata.id')
            ->leftjoin('fungsional', 'pegawai.fungsional_id', '=', 'fungsional.id')
            ->leftjoin('direktorat', 'pegawai.direktorat_id', '=', 'direktorat.id')
            ->leftjoin('jenis_tenaga', 'pegawai.jenis_tenaga_id', '=', 'jenis_tenaga.id')
            ->leftjoin('status_kepegawaian', 'pegawai.status_kepegawaian_id', '=', 'status_kepegawaian.id')
            ->leftjoin('pendidikan', 'pendidikan.biodata_id', '=', 'biodata.id')
            ->leftjoin('unit', 'pegawai.unit_id', '=', 'unit.id')
            ->get()->toArray(); // Ambil data pegawai sesuai filter yang diberikan


        // Simpan hasil ke properti untuk digunakan di view
        $this->data = $results; // Simpan hasil ke properti

    }
}
