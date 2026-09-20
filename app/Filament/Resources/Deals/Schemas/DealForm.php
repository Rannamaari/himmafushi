<?php

namespace App\Filament\Resources\Deals\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DealForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('business_id')
                    ->relationship('business', 'name'),
                Select::make('guesthouse_id')
                    ->relationship('guesthouse', 'name'),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('original_price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('deal_price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('currency'),
                TextInput::make('customer_type')
                    ->required()
                    ->default('all'),
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('ends_at'),
                Toggle::make('featured')
                    ->required(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
