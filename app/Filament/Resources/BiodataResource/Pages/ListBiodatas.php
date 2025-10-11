<?php

namespace App\Filament\Resources\BiodataResource\Pages;

use App\Filament\Resources\BiodataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SyncController;

class ListBiodatas extends ListRecords
{
    protected static string $resource = BiodataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('sync')
                ->label('Sync Pegawai')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->requiresConfirmation()
                ->successNotificationTitle('Pegawai berhasil disinkronkan')
                ->hidden(fn() => config('app.debug') === true ? false : true)
                ->action(function () {
                    // Logic to sync employees
                    // This could be a call to a service that fetches and updates employee data
                    // For example:
                    // EmployeeService::syncEmployees();
                    // Assuming the sync operation is successful
                    // You can also handle any errors or exceptions as needed
                    // For now, we will just flash a success message
                    SyncController::syncPegawai(); // Assuming you have a SyncPegawai service to handle the sync logic
                    session()->flash('success', 'Pegawai berhasil disinkronkan');
                }),
            Actions\Action::make('syncUserAkses')
                ->label('Sync User Akses')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->hidden(fn() => config('app.debug') === true ? false : true)
                ->requiresConfirmation()
                ->successNotificationTitle('User akses berhasil disinkronkan')
                ->action(function () {
                    SyncController::syncUserAkses();
                    $recipient = Auth::user();
                    Notification::make()
                        ->title('User akses berhasil disinkronkan')
                        ->body('Login menggunakan email: ' . $recipient->email . ' dengan Password default: password')
                        ->success()
                        ->sendToDatabase($recipient);
                }),
        ];
    }
}
