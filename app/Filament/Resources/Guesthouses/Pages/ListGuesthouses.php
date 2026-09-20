<?php

namespace App\Filament\Resources\Guesthouses\Pages;

use App\Filament\Resources\Guesthouses\GuesthouseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGuesthouses extends ListRecords
{
    protected static string $resource = GuesthouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
