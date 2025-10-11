<?php

namespace App\Filament\Resources\StrukturalResource\Pages;

use App\Filament\Resources\StrukturalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageStrukturals extends ManageRecords
{
    protected static string $resource = StrukturalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('sync')
                ->label('Sync Struktural')
                ->color('success')
                ->icon('heroicon-o-arrow-path')
                ->action(
                    function () {
                        \App\Http\Controllers\SyncController::syncStruktural();
                        session()->flash('success', 'Data struktural berhasil disinkronkan');
                    }
                )
                ->requiresConfirmation()
                ->modalHeading('Sync Struktural')
                ->modalSubheading('Apakah anda yakin ingin mensync data struktural dari data coba?'),
        ];
    }
}
