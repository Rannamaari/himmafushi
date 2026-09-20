<?php

namespace App\Filament\Resources\BusinessServices\Pages;

use App\Filament\Resources\BusinessServices\BusinessServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBusinessService extends EditRecord
{
    protected static string $resource = BusinessServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
