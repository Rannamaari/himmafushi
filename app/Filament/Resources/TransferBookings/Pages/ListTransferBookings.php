<?php

namespace App\Filament\Resources\TransferBookings\Pages;

use App\Filament\Resources\TransferBookings\TransferBookingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransferBookings extends ListRecords
{
    protected static string $resource = TransferBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
