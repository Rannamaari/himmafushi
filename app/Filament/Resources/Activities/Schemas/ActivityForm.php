<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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
                TextInput::make('category')->helperText('Examples: Surfing, Snorkelling, Fishing, Island hopping, Package.'),
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
                Repeater::make('price_tiers')
                    ->label('Per-person USD price tiers')
                    ->schema([
                        TextInput::make('label')->required()->placeholder('1 person, 2 people, 3 people, 4+ people'),
                        TextInput::make('amount')->numeric()->required()->prefix('$'),
                    ])
                    ->columns(2)
                    ->addActionLabel('Add guest price')
                    ->defaultItems(0)
                    ->helperText('Add the price rows shown on the partner list, such as 1, 2, 3 and 5+ people. Amount is USD per person; leave unlisted group sizes without a row.')
                    ->columnSpanFull(),
                TextInput::make('duration_minutes')
                    ->numeric(),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('activities')
                    ->visibility('public')
                    ->imageEditor()
                    ->openable()
                    ->maxSize(8192),
                TextInput::make('whatsapp'),
                Toggle::make('featured')
                    ->required(),
                TextInput::make('featured_order')->numeric()->default(0),
                DateTimePicker::make('featured_from')->seconds(false),
                DateTimePicker::make('featured_until')->seconds(false),
                Toggle::make('active')
                    ->required(),
                Toggle::make('booking_available')
                    ->required(),
                Toggle::make('partner_excursion')->label('Ocean Monkey excursion')->helperText('Show Ocean Monkey as the local excursion operator.'),
            ]);
    }
}
