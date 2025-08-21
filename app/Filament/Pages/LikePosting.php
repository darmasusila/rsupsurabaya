<?php

namespace App\Filament\Pages;

use App\Models\Biodata;
use App\Models\Pegawai;
use App\Models\Post;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Posting;

class LikePosting extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.like-posting';

    protected static ?string $navigationGroup = 'Posting';
    protected static ?string $navigationLabel = 'Posting Liked Pegawai';

    public $data = []; // Untuk menyimpan data form

    public ?Collection $reportResults = null; // Untuk menyimpan hasil laporan

    public static function shouldRegisterNavigation(): bool
    {
        // saat ini dimatikan       
        return false;
    }

    public function mount(): void
    {
        $this->generateData(); // Panggil generateReport saat halaman dimuat
    }



    public function generateData(): void
    {
        // Lakukan query untuk mendapatkan data pegawai berdasarkan filter
        $biodataId = Biodata::where('email', Auth::user()->email)->value('id');
        $pegawaiId = Pegawai::where('biodata_id', $biodataId)->value('id');

        $results = Posting::Select(
            'posting_liked.id',
            'posting.judul',
            'posting.url',
            'posting.jenis',
        )
            ->join('posting_liked', 'posting.id', '=', 'posting_liked.posting_id')
            ->where('posting_liked.pegawai_id', $pegawaiId)
            ->where('posting.is_active', true)
            ->where('posting_liked.is_open_link', false)
            ->get(); // Ambil data pegawai sesuai filter yang diberikan

        // dd($results); // Debugging: tampilkan hasil query

        // Simpan hasil ke properti untuk digunakan di view
        $this->data = $results; // Simpan hasil ke properti

    }
}
