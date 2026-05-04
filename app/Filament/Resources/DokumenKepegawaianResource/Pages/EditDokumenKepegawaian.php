<?php

namespace App\Filament\Resources\DokumenKepegawaianResource\Pages;

use App\Filament\Resources\DokumenKepegawaianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDokumenKepegawaian extends EditRecord
{
    protected static string $resource = DokumenKepegawaianResource::class;

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
