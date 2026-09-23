<?php

namespace App\Filament\Resources\ActivityBookingRequests\Pages;

use App\Filament\Resources\ActivityBookingRequests\ActivityBookingRequestResource;
use Filament\Resources\Pages\ListRecords;

class ListActivityBookingRequests extends ListRecords
{
    protected static string $resource = ActivityBookingRequestResource::class;
}
