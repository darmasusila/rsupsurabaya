<?php

namespace App\Filament\Resources\UnitResource\Pages;

use App\Filament\Resources\UnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUnits extends ManageRecords
{
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('sync')
                ->label('Sync Unit Kerja')
                ->color('success')
                ->icon('heroicon-o-arrow-path')
                ->hidden(fn() => config('app.debug') === true ? false : true)
                ->action(
                    function () {
                        \App\Http\Controllers\SyncController::syncUnit();
                        session()->flash('success', 'Data unit kerja berhasil disinkronkan');
                    }
                )
                ->requiresConfirmation()
                ->modalHeading('Sync Unit Kerja')
                ->modalSubheading('Apakah anda yakin ingin mensync data unit kerja dari data coba?'),
        ];
    }
}
