<?php

namespace App\Filament\Resources\DokumenResource\Pages;

use App\Filament\Resources\DokumenResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ManageDokumens extends ManageRecords
{
    protected static string $resource = DokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(
                    function () {
                        $user = User::find(Auth::id());

                        return $user->can('create_dokumen');
                    }
                )
                ->mutateFormDataUsing(function (array $data): array {
                    $data['nama_pengupload'] = Auth::user()->name;
                    $data['slug'] = $data['nama_dokumen'] ? Str::slug($data['nama_dokumen']) : '';
                    if ($data['file_name']) {
                        $data['url'] = route('file.open', ['fileName' => $data['file_name']]) ?? '';
                    }
                    return $data;
                }),
        ];
    }
}
