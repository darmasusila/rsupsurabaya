<?php

namespace App\Filament\Resources\FungsionalResource\Pages;

use App\Filament\Resources\FungsionalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFungsionals extends ManageRecords
{
    protected static string $resource = FungsionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
