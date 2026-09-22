<?php

namespace App\Filament\Resources\GuesthouseBookingRequests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GuesthouseBookingRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reference'),
                Select::make('guesthouse_id')
                    ->relationship('guesthouse', 'name'),
                TextInput::make('customer_type')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('whatsapp')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('country'),
                DatePicker::make('check_in')
                    ->label('Check-in (collected on WhatsApp)'),
                DatePicker::make('check_out')
                    ->label('Check-out (collected on WhatsApp)'),
                TextInput::make('adults')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('children')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('room_preference'),
                TextInput::make('meal_plan'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('new'),
                TextInput::make('quote_amount')
                    ->numeric(),
                TextInput::make('quote_currency'),
                Textarea::make('supplier_confirmation')
                    ->columnSpanFull(),
            ]);
    }
}
