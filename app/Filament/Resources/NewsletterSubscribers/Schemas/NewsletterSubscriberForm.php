<?php

namespace App\Filament\Resources\NewsletterSubscribers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NewsletterSubscriberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('email')->email()->required()->maxLength(255),
            Select::make('status')->options(['active' => 'Active', 'unsubscribed' => 'Unsubscribed'])->required(),
            DateTimePicker::make('consented_at')->required()->seconds(false),
        ]);
    }
}
