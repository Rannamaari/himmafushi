<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
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
            Select::make('article_category_id')->relationship('category', 'name')->label('Category')->searchable()->preload()->required(),
            Textarea::make('excerpt')->required()->maxLength(500)->columnSpanFull(),
            RichEditor::make('body')->required()->fileAttachmentsDisk('public')->fileAttachmentsDirectory('articles/content')->columnSpanFull(),
            FileUpload::make('image')->image()->disk('public')->directory('articles'),
            TextInput::make('seo_title'), Textarea::make('seo_description')->maxLength(500),
            DateTimePicker::make('published_at'), Toggle::make('featured')->required(), Toggle::make('active')->required(),
        ]);
    }
}
