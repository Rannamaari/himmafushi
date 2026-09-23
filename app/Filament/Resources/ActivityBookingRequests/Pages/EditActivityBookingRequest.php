<?php

namespace App\Filament\Resources\ActivityBookingRequests\Pages;

use App\Filament\Resources\ActivityBookingRequests\ActivityBookingRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditActivityBookingRequest extends EditRecord
{
    protected static string $resource = ActivityBookingRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
