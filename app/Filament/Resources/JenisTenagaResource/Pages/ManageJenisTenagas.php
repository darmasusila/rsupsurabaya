<?php

namespace App\Filament\Resources\JenisTenagaResource\Pages;

use App\Filament\Resources\JenisTenagaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageJenisTenagas extends ManageRecords
{
    protected static string $resource = JenisTenagaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
