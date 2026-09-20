<?php

namespace App\Filament\Resources\Guesthouses\Pages;

use App\Filament\Resources\Guesthouses\GuesthouseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGuesthouse extends EditRecord
{
    protected static string $resource = GuesthouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
