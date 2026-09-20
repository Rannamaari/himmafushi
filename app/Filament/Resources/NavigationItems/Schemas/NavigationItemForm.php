<?php

namespace App\Filament\Resources\NavigationItems\Schemas;

use App\Models\NavigationItem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NavigationItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('label')->required()->maxLength(100),
            TextInput::make('key')->required()->unique(ignoreRecord: true)->helperText('A unique internal name, for example airport-transfer.'),
            Select::make('parent_id')->label('Parent menu')->options(fn () => NavigationItem::whereNull('parent_id')->orderBy('sort_order')->pluck('label', 'id'))->searchable()->preload(),
            Select::make('menu_style')->options(['link' => 'Direct link', 'dropdown' => 'Dropdown', 'mega' => 'Wide dropdown'])->default('link')->required(),
            TextInput::make('menu_heading')->helperText('Optional heading shown inside a dropdown.'),
            TextInput::make('route_name')->helperText('Laravel route name, for example guesthouses.index.'),
            TextInput::make('url')->url()->helperText('Use this for an external link. A route name takes priority.'),
            TextInput::make('active_route_pattern')->helperText('Controls the active state, for example guesthouses.*.'),
            TextInput::make('sort_order')->numeric()->default(0)->required(),
            Toggle::make('show_in_desktop')->default(true),
            Toggle::make('show_in_mobile')->default(true),
            Toggle::make('open_in_new_tab')->default(false),
            Toggle::make('active')->default(true)->required(),
        ]);
    }
}
