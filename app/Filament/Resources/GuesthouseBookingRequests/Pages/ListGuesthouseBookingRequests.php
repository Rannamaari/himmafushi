<?php

namespace App\Filament\Resources\GuesthouseBookingRequests\Pages;

use App\Filament\Resources\GuesthouseBookingRequests\GuesthouseBookingRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGuesthouseBookingRequests extends ListRecords
{
    protected static string $resource = GuesthouseBookingRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
