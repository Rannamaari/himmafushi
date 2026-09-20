<?php

namespace App\Filament\Resources\Guesthouses\Pages;

use App\Filament\Resources\Guesthouses\GuesthouseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGuesthouse extends CreateRecord
{
    protected static string $resource = GuesthouseResource::class;
}
