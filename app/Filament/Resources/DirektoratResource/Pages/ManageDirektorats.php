<?php

namespace App\Filament\Resources\DirektoratResource\Pages;

use App\Filament\Resources\DirektoratResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDirektorats extends ManageRecords
{
    protected static string $resource = DirektoratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
