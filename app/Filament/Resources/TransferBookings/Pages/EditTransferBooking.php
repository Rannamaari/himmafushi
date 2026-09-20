<?php

namespace App\Filament\Resources\TransferBookings\Pages;

use App\Filament\Resources\TransferBookings\TransferBookingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTransferBooking extends EditRecord
{
    protected static string $resource = TransferBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
