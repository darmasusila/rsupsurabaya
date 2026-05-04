<?php

namespace App\Filament\Clusters\Referensi\Resources\JenisDokumenResource\Pages;

use App\Filament\Clusters\Referensi\Resources\JenisDokumenResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageJenisDokumens extends ManageRecords
{
    protected static string $resource = JenisDokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
