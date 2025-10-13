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
            Actions\Action::make('sync')
                ->label('Sync Direktorat')
                ->color('success')
                ->icon('heroicon-o-arrow-path')
                ->hidden(fn() => config('app.debug') === true ? false : true)
                ->action(
                    function () {
                        \App\Http\Controllers\SyncController::syncDirektorat();
                        session()->flash('success', 'Data direktorat berhasil disinkronkan');
                    }
                )
                ->requiresConfirmation()
                ->modalHeading('Sync Direktorat')
                ->modalSubheading('Apakah anda yakin ingin mensync data direktorat dari data coba?'),
        ];
    }
}
