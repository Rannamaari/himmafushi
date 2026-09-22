<?php

namespace App\Filament\Resources\Businesses\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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
                Textarea::make('short_description')
                    ->label('Short excerpt')
                    ->rows(3)
                    ->maxLength(240)
                    ->helperText('Shown on directory cards and search results.')
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->label('Full business information')
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('businesses/content')
                    ->fileAttachmentsVisibility('public')
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
                    ->label('Listing image')
                    ->image()
                    ->disk('public')
                    ->directory('businesses')
                    ->visibility('public')
                    ->imageEditor()
                    ->openable()
                    ->downloadable()
                    ->maxSize(8192),
                FileUpload::make('cover_image')
                    ->label('Page cover image')
                    ->image()
                    ->disk('public')
                    ->directory('businesses/covers')
                    ->visibility('public')
                    ->imageEditor()
                    ->openable()
                    ->downloadable()
                    ->maxSize(8192),
                FileUpload::make('gallery')
                    ->label('Photo gallery')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->appendFiles()
                    ->disk('public')
                    ->directory('businesses/gallery')
                    ->visibility('public')
                    ->imageEditor()
                    ->openable()
                    ->downloadable()
                    ->maxFiles(16)
                    ->maxSize(8192)
                    ->helperText('Upload up to 16 photos. Drag to set their display order.')
                    ->columnSpanFull(),
                TextInput::make('display_priority')
                    ->label('Display priority')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Higher numbers appear first in this business category.'),
                Toggle::make('delivery_available')
                    ->required(),
                Toggle::make('takeaway_available')
                    ->required(),
                Toggle::make('dine_in_available')
                    ->required(),
                Toggle::make('featured')
                    ->required(),
                TextInput::make('featured_order')->numeric()->default(0),
                DateTimePicker::make('featured_from')->seconds(false),
                DateTimePicker::make('featured_until')->seconds(false),
                Toggle::make('active')
                    ->required(),
                TextInput::make('latitude')
                    ->label('Google Maps latitude')
                    ->numeric()
                    ->step('any')
                    ->minValue(-90)
                    ->maxValue(90)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? round((float) $state, 7) : null)
                    ->helperText('In Google Maps, right-click the exact location and copy the first number.'),
                TextInput::make('longitude')
                    ->label('Google Maps longitude')
                    ->numeric()
                    ->step('any')
                    ->minValue(-180)
                    ->maxValue(180)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? round((float) $state, 7) : null)
                    ->helperText('Paste the complete second coordinate from Google Maps; extra decimal places are rounded automatically.'),
                TextInput::make('google_maps_url')
                    ->label('Google Maps share URL')
                    ->url()
                    ->columnSpanFull()
                    ->helperText('Paste the Share link from Google Maps. When you save, the exact latitude and longitude are filled automatically.'),
            ]);
    }
}
