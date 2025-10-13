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
            Actions\Action::make('sync')
                ->label('Sync Fungsional')
                ->color('success')
                ->icon('heroicon-o-arrow-path')
                ->hidden(fn() => config('app.debug') === true ? false : true)
                ->action(
                    function () {
                        \App\Http\Controllers\SyncController::syncProfesi();
                        session()->flash('success', 'Data fungsional berhasil disinkronkan');
                    }
                )
                ->requiresConfirmation()
                ->modalHeading('Sync Fungsional')
                ->modalSubheading('Apakah anda yakin ingin mensync data fungsional dari data coba?'),
        ];
    }
}
