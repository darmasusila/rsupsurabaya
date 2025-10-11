<?php

namespace App\Filament\Resources\PlafonCutiResource\Pages;

use App\Filament\Resources\PlafonCutiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePlafonCuti extends CreateRecord
{
    protected static string $resource = PlafonCutiResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
