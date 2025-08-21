<?php

namespace App\Filament\Resources\StrukturalResource\Pages;

use App\Filament\Resources\StrukturalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageStrukturals extends ManageRecords
{
    protected static string $resource = StrukturalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
