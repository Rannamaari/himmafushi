<?php

namespace App\Filament\Resources\Transfers\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TransferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('from_location')
                    ->required(),
                TextInput::make('to_location')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->default('scheduled_speedboat'),
                TimePicker::make('departure_time'),
                CheckboxList::make('operating_days')
                    ->options([
                        'monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday',
                        'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday',
                    ])
                    ->columns(4),
                TextInput::make('local_price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('tourist_price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('tourist_currency')
                    ->required()
                    ->default('USD'),
                TextInput::make('duration_minutes')
                    ->numeric(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
