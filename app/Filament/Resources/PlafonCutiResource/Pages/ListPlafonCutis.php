<?php

namespace App\Filament\Resources\PlafonCutiResource\Pages;

use App\Filament\Resources\PlafonCutiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SyncController;

class ListPlafonCutis extends ListRecords
{
    protected static string $resource = PlafonCutiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Set Plafon Cuti')
                ->label('Set Plafon Cuti')
                ->icon('heroicon-o-clock')
                ->color('success')
                ->requiresConfirmation()
                ->successNotificationTitle('Plafon Cuti Berhasil Disimpan')
                ->action(function () {
                    SyncController::syncPlafonCuti();
                    $recipient = Auth::user();
                    Notification::make()
                        ->title('Plafon Cuti Berhasil Disimpan')
                        ->body('Silakan cek pada menu Plafon Cuti, Default Cuti Tahunan 12 Hari')
                        ->success()
                        ->sendToDatabase($recipient);
                }),
        ];
    }
}
