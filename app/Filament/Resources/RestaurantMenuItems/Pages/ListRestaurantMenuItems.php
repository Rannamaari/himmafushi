<?php

namespace App\Filament\Resources\RestaurantMenuItems\Pages;

use App\Filament\Resources\RestaurantMenuItems\RestaurantMenuItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRestaurantMenuItems extends ListRecords
{
    protected static string $resource = RestaurantMenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
