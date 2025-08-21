<?php

namespace App\Filament\Resources\PostingResource\Pages;

use App\Filament\Resources\PostingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePostings extends ManageRecords
{
    protected static string $resource = PostingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
