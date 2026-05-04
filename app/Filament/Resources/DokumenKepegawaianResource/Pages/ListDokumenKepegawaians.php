<?php

namespace App\Filament\Resources\DokumenKepegawaianResource\Pages;

use App\Filament\Resources\DokumenKepegawaianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;


class ListDokumenKepegawaians extends ListRecords
{
    protected static string $resource = DokumenKepegawaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\DokumenKepegawaianResource\Widgets\DokumenReminder::class,
        ];
    }
}
