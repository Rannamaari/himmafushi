<?php

namespace App\Filament\Resources\GuesthouseBookingRequests\Pages;

use App\Filament\Resources\GuesthouseBookingRequests\GuesthouseBookingRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGuesthouseBookingRequest extends EditRecord
{
    protected static string $resource = GuesthouseBookingRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
