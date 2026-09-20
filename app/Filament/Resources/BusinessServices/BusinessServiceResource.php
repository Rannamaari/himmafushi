<?php

namespace App\Filament\Resources\BusinessServices;

use App\Filament\Resources\BusinessServices\Pages\CreateBusinessService;
use App\Filament\Resources\BusinessServices\Pages\EditBusinessService;
use App\Filament\Resources\BusinessServices\Pages\ListBusinessServices;
use App\Filament\Resources\BusinessServices\Schemas\BusinessServiceForm;
use App\Filament\Resources\BusinessServices\Tables\BusinessServicesTable;
use App\Models\BusinessService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BusinessServiceResource extends Resource
{
    protected static ?string $model = BusinessService::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Directory';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BusinessServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BusinessServicesTable::configure($table);
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
            'index' => ListBusinessServices::route('/'),
            'create' => CreateBusinessService::route('/create'),
            'edit' => EditBusinessService::route('/{record}/edit'),
        ];
    }
}
