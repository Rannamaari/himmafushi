<?php

namespace App\Filament\Resources\ActivityBookingRequests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ActivityBookingRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('reference')->disabled()->dehydrated(false),
            TextInput::make('activity_name')->disabled()->dehydrated(false),
            DatePicker::make('preferred_date')->required(),
            TextInput::make('participants')->numeric()->required(),
            TextInput::make('name')->required(),
            TextInput::make('whatsapp')->tel()->required(),
            TextInput::make('nationality'),
            TextInput::make('estimated_total')->numeric()->prefix('USD'),
            Select::make('status')->options(['new' => 'New', 'contacted' => 'Contacted', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled'])->required(),
            Textarea::make('notes')->columnSpanFull(),
        ]);
    }
}
