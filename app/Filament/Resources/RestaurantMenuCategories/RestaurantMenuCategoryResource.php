<?php

namespace App\Filament\Resources\RestaurantMenuCategories;

use App\Filament\Resources\RestaurantMenuCategories\Pages\CreateRestaurantMenuCategory;
use App\Filament\Resources\RestaurantMenuCategories\Pages\EditRestaurantMenuCategory;
use App\Filament\Resources\RestaurantMenuCategories\Pages\ListRestaurantMenuCategories;
use App\Filament\Resources\RestaurantMenuCategories\Schemas\RestaurantMenuCategoryForm;
use App\Filament\Resources\RestaurantMenuCategories\Tables\RestaurantMenuCategoriesTable;
use App\Models\RestaurantMenuCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RestaurantMenuCategoryResource extends Resource
{
    protected static ?string $model = RestaurantMenuCategory::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Directory';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RestaurantMenuCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RestaurantMenuCategoriesTable::configure($table);
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
            'index' => ListRestaurantMenuCategories::route('/'),
            'create' => CreateRestaurantMenuCategory::route('/create'),
            'edit' => EditRestaurantMenuCategory::route('/{record}/edit'),
        ];
    }
}
