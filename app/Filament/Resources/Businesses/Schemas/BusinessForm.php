<?php

namespace App\Filament\Resources\Businesses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BusinessForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('business_category_id')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('short_description'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('whatsapp'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('address'),
                TimePicker::make('opening_time'),
                TimePicker::make('closing_time'),
                TextInput::make('price_range'),
                FileUpload::make('image')
                    ->image(),
                FileUpload::make('cover_image')
                    ->image(),
                Toggle::make('delivery_available')
                    ->required(),
                Toggle::make('takeaway_available')
                    ->required(),
                Toggle::make('dine_in_available')
                    ->required(),
                Toggle::make('featured')
                    ->required(),
                Toggle::make('active')
                    ->required(),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
            ]);
    }
}
