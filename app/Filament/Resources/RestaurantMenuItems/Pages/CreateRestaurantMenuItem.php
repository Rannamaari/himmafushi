<?php

namespace App\Filament\Resources\RestaurantMenuItems\Pages;

use App\Filament\Resources\RestaurantMenuItems\RestaurantMenuItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRestaurantMenuItem extends CreateRecord
{
    protected static string $resource = RestaurantMenuItemResource::class;
}
