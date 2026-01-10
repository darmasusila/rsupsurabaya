<?php

namespace App\Filament\Resources\MagangResource\Pages;

use App\Filament\Resources\MagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMagangs extends ListRecords
{
    protected static string $resource = MagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MagangResource\Widgets\MagangOverview::class,
        ];
    }
}
