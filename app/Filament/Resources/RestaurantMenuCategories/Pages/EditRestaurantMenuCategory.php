<?php

namespace App\Filament\Resources\RestaurantMenuCategories\Pages;

use App\Filament\Resources\RestaurantMenuCategories\RestaurantMenuCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRestaurantMenuCategory extends EditRecord
{
    protected static string $resource = RestaurantMenuCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
