<?php

namespace App\Filament\Resources\Guesthouses\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GuesthouseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('excerpt')
                    ->label('Short excerpt')
                    ->rows(3)
                    ->maxLength(240)
                    ->helperText('Shown on guesthouse cards and search results. Keep this short and persuasive.')
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->label('Full guesthouse information')
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('guesthouses/content')
                    ->fileAttachmentsVisibility('public')
                    ->columnSpanFull(),
                TextInput::make('address'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                FileUpload::make('image')
                    ->label('Main listing image')
                    ->image()
                    ->disk('public')
                    ->directory('guesthouses')
                    ->visibility('public')
                    ->imageEditor()
                    ->openable()
                    ->downloadable()
                    ->maxSize(8192)
                    ->helperText('Main image used on cards and at the top of the guesthouse page. Maximum 8 MB.'),
                FileUpload::make('gallery')
                    ->label('Photo gallery')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->appendFiles()
                    ->disk('public')
                    ->directory('guesthouses/gallery')
                    ->visibility('public')
                    ->imageEditor()
                    ->openable()
                    ->downloadable()
                    ->maxFiles(16)
                    ->maxSize(8192)
                    ->helperText('Upload up to 16 room, exterior, beach and facilities photos. Drag to reorder.')
                    ->columnSpanFull(),
                TextInput::make('display_priority')
                    ->label('Display priority')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Higher numbers appear first in the guesthouse listing.'),
                TextInput::make('local_rate_from')
                    ->numeric(),
                TextInput::make('tourist_rate_from')
                    ->numeric(),
                Toggle::make('featured')
                    ->required(),
                TextInput::make('featured_priority')->numeric()->minValue(0)->default(0)
                    ->helperText('Higher numbers appear first in featured homepage placements.'),
                DateTimePicker::make('featured_start_at')->seconds(false),
                DateTimePicker::make('featured_end_at')->seconds(false),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
