<?php

namespace App\Filament\Resources\NavigationItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NavigationItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table->defaultSort('sort_order')->columns([
            TextColumn::make('label')->searchable()->sortable(),
            TextColumn::make('parent.label')->label('Parent')->placeholder('Top level'),
            TextColumn::make('menu_style')->badge(),
            TextColumn::make('route_name')->searchable(),
            TextColumn::make('sort_order')->numeric()->sortable(),
            IconColumn::make('show_in_desktop')->label('Desktop')->boolean(),
            IconColumn::make('show_in_mobile')->label('Mobile')->boolean(),
            IconColumn::make('active')->boolean(),
        ])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
