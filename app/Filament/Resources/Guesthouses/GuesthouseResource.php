<?php

namespace App\Filament\Resources\Guesthouses;

use App\Filament\Resources\Guesthouses\Pages\CreateGuesthouse;
use App\Filament\Resources\Guesthouses\Pages\EditGuesthouse;
use App\Filament\Resources\Guesthouses\Pages\ListGuesthouses;
use App\Filament\Resources\Guesthouses\Schemas\GuesthouseForm;
use App\Filament\Resources\Guesthouses\Tables\GuesthousesTable;
use App\Models\Guesthouse;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GuesthouseResource extends Resource
{
    protected static ?string $model = Guesthouse::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Travel';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return GuesthouseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GuesthousesTable::configure($table);
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
            'index' => ListGuesthouses::route('/'),
            'create' => CreateGuesthouse::route('/create'),
            'edit' => EditGuesthouse::route('/{record}/edit'),
        ];
    }
}
