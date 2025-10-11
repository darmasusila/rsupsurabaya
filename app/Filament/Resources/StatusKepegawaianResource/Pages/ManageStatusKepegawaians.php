<?php

namespace App\Filament\Resources\StatusKepegawaianResource\Pages;

use App\Filament\Resources\StatusKepegawaianResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageStatusKepegawaians extends ManageRecords
{
    protected static string $resource = StatusKepegawaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('sync')
                ->label('Sync Status Kepegawaian')
                ->color('success')
                ->icon('heroicon-o-arrow-path')
                ->action(
                    function () {
                        \App\Http\Controllers\SyncController::syncStatus();
                        session()->flash('success', 'Data status kepegawaian berhasil disinkronkan');
                    }
                )
                ->requiresConfirmation()
                ->modalHeading('Sync Status Kepegawaian')
                ->modalSubheading('Apakah anda yakin ingin mensync data status kepegawaian dari data coba?'),
        ];
    }
}
