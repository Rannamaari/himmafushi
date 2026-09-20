<?php

namespace App\Filament\Resources\RestaurantMenuItems\Pages;

use App\Filament\Resources\RestaurantMenuItems\RestaurantMenuItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRestaurantMenuItem extends EditRecord
{
    protected static string $resource = RestaurantMenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
