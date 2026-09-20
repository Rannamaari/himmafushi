<?php

namespace App\Filament\Resources\RestaurantMenuItems;

use App\Filament\Resources\RestaurantMenuItems\Pages\CreateRestaurantMenuItem;
use App\Filament\Resources\RestaurantMenuItems\Pages\EditRestaurantMenuItem;
use App\Filament\Resources\RestaurantMenuItems\Pages\ListRestaurantMenuItems;
use App\Filament\Resources\RestaurantMenuItems\Schemas\RestaurantMenuItemForm;
use App\Filament\Resources\RestaurantMenuItems\Tables\RestaurantMenuItemsTable;
use App\Models\RestaurantMenuItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RestaurantMenuItemResource extends Resource
{
    protected static ?string $model = RestaurantMenuItem::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Directory';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RestaurantMenuItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RestaurantMenuItemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRestaurantMenuItems::route('/'),
            'create' => CreateRestaurantMenuItem::route('/create'),
            'edit' => EditRestaurantMenuItem::route('/{record}/edit'),
        ];
    }
}
