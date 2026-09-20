<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('short_description'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('price_from')
                    ->numeric(),
                TextInput::make('currency'),
                TextInput::make('local_price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('tourist_price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('duration_minutes')
                    ->numeric(),
                FileUpload::make('image')
                    ->image(),
                TextInput::make('whatsapp'),
                Toggle::make('featured')
                    ->required(),
                Toggle::make('active')
                    ->required(),
                Toggle::make('booking_available')
                    ->required(),
            ]);
    }
}
