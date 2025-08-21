<?php

namespace App\Filament\Resources\PostingLikedResource\Pages;

use App\Filament\Resources\PostingLikedResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePostingLikeds extends ManageRecords
{
    protected static string $resource = PostingLikedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
