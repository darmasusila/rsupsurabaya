<?php

namespace App\Filament\Resources\MagangResource\Pages;

use App\Filament\Resources\MagangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMagang extends EditRecord
{
    protected static string $resource = MagangResource::class;

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
