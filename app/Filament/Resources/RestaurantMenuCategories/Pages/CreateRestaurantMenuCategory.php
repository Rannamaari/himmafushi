<?php

namespace App\Filament\Resources\RestaurantMenuCategories\Pages;

use App\Filament\Resources\RestaurantMenuCategories\RestaurantMenuCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRestaurantMenuCategory extends CreateRecord
{
    protected static string $resource = RestaurantMenuCategoryResource::class;
}
