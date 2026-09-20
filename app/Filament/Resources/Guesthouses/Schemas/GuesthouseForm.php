<?php

namespace App\Filament\Resources\Guesthouses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GuesthouseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('address'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('guesthouses'),
                TextInput::make('local_rate_from')
                    ->numeric(),
                TextInput::make('tourist_rate_from')
                    ->numeric(),
                Toggle::make('featured')
                    ->required(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
