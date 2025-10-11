<?php

namespace App\Filament\Resources\PlafonCutiResource\Pages;

use App\Filament\Resources\PlafonCutiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlafonCuti extends EditRecord
{
    protected static string $resource = PlafonCutiResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
