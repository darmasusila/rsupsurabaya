<?php

namespace App\Filament\Clusters\Cutis\Resources\PersetujuanCutiResource\Pages;

use App\Filament\Clusters\Cutis\Resources\PersetujuanCutiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePersetujuanCutis extends ManageRecords
{
    protected static string $resource = PersetujuanCutiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
