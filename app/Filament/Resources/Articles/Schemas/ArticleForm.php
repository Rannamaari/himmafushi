<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->columnSpanFull(), TextInput::make('slug')->required(),
            Textarea::make('excerpt')->required()->maxLength(500)->columnSpanFull(), Textarea::make('body')->required()->rows(14)->columnSpanFull(),
            FileUpload::make('image')->image()->disk('public')->directory('articles'),
            TextInput::make('seo_title'), Textarea::make('seo_description')->maxLength(500),
            DateTimePicker::make('published_at'), Toggle::make('featured')->required(), Toggle::make('active')->required(),
        ]);
    }
}
