<?php

namespace App\Filament\Clusters\Referensi\Resources\DepartemenResource\Pages;

use App\Filament\Clusters\Referensi\Resources\DepartemenResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDepartemens extends ManageRecords
{
    protected static string $resource = DepartemenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('sync')
                ->label('Sync Departemen')
                ->color('success')
                ->icon('heroicon-o-arrow-path')
                ->hidden(fn() => config('app.debug') === true ? false : true)
                ->action(
                    function () {
                        \App\Http\Controllers\SyncController::syncDepartemen();
                        session()->flash('success', 'Data departemen berhasil disinkronkan');
                    }
                )
                ->requiresConfirmation()
                ->modalHeading('Sync Departemen')
                ->modalSubheading('Apakah anda yakin ingin mensync data departemen dari data coba?'),
        ];
    }
}
