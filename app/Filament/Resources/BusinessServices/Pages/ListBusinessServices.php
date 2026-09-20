<?php

namespace App\Filament\Resources\BusinessServices\Pages;

use App\Filament\Resources\BusinessServices\BusinessServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBusinessServices extends ListRecords
{
    protected static string $resource = BusinessServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
