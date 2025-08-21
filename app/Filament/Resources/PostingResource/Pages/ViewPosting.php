<?php

namespace App\Filament\Resources\PostingResource\Pages;

use App\Filament\Resources\PostingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPosting extends ViewRecord
{
    protected static string $resource = PostingResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
