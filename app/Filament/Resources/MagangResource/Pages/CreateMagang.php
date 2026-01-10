<?php

namespace App\Filament\Resources\MagangResource\Pages;

use App\Filament\Resources\MagangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMagang extends CreateRecord
{
    protected static string $resource = MagangResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
