<?php

namespace App\Filament\Resources\RestaurantMenuCategories\Pages;

use App\Filament\Resources\RestaurantMenuCategories\RestaurantMenuCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRestaurantMenuCategories extends ListRecords
{
    protected static string $resource = RestaurantMenuCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
