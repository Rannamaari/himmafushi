<?php

namespace App\Filament\Resources\TransferBookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class TransferBookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reference'),
                Select::make('transfer_id')
                    ->relationship('transfer', 'name'),
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
                DatePicker::make('travel_date')
                    ->required(),
                TextInput::make('preferred_time'),
                TextInput::make('passengers')
                    ->label('Chargeable guests (age 3+)')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('infants')
                    ->label('Infants (age 0-2, free)')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('flight_number'),
                TimePicker::make('flight_time'),
                TextInput::make('pickup_location'),
                TextInput::make('dropoff_location'),
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
