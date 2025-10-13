<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MottoTujuanWidget extends Widget
{
    protected static ?int $sort = 5;
    protected static string $view = 'filament.widgets.motto-tujuan-widget';
    public ?array $data = []; // Untuk menyimpan data form
    public ?string $activeTab = 'tab_1';
    public ?bool $visible = false;
    protected int | string | array $columnSpan = 'full';

    public function mount()
    {
        $user = User::find(Auth::id());
        // Inisialisasi data atau logika lainnya jika diperlukan
        $this->data = [
            'visible' => $user->can('view_any_pegawai'),
        ];
    }
}
