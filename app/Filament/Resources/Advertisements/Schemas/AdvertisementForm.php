<?php

namespace App\Filament\Resources\Advertisements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AdvertisementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('advertiser')->required(),
            Select::make('placement')->options([
                'home_search_sponsor' => 'Homepage search sponsor',
                'home_after_blog' => 'Homepage after blog',
                'home_after_featured' => 'Homepage after featured',
                'guesthouse_listing' => 'Guesthouse listing',
                'restaurant_listing' => 'Restaurant listing',
                'blog_sidebar' => 'Blog sidebar',
                'blog_after_content' => 'Blog after content',
                'site_head' => 'Global AdSense head tag',
                'site_after_content' => 'Every page after content',
            ])->required()->searchable(),
            TextInput::make('headline')->columnSpanFull(),
            Textarea::make('copy')->rows(4)->columnSpanFull(),
            FileUpload::make('image')->label('Desktop image')->image()->disk('public')->directory('advertisements'),
            FileUpload::make('mobile_image')->label('Mobile image')->image()->disk('public')->directory('advertisements'),
            TextInput::make('cta_label'),
            TextInput::make('destination_url')->maxLength(2048)->columnSpanFull(),
            Textarea::make('embed_code')->label('AdSense / embed code')->rows(9)->columnSpanFull()->helperText('Paste trusted ad code here. For Google AdSense setup, use the Global AdSense head tag placement.'),
            TextInput::make('priority')->numeric()->default(0)->required(),
            DateTimePicker::make('starts_at')->seconds(false),
            DateTimePicker::make('ends_at')->seconds(false),
            Toggle::make('active')->default(true)->required(),
        ]);
    }
}
