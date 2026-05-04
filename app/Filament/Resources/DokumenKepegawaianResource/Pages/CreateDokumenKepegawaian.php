<?php

namespace App\Filament\Resources\DokumenKepegawaianResource\Pages;

use App\Filament\Resources\DokumenKepegawaianResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDokumenKepegawaian extends CreateRecord
{
    protected static string $resource = DokumenKepegawaianResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
