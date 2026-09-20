<?php

namespace App\Filament\Resources\GuesthouseBookingRequests;

use App\Filament\Resources\GuesthouseBookingRequests\Pages\CreateGuesthouseBookingRequest;
use App\Filament\Resources\GuesthouseBookingRequests\Pages\EditGuesthouseBookingRequest;
use App\Filament\Resources\GuesthouseBookingRequests\Pages\ListGuesthouseBookingRequests;
use App\Filament\Resources\GuesthouseBookingRequests\Schemas\GuesthouseBookingRequestForm;
use App\Filament\Resources\GuesthouseBookingRequests\Tables\GuesthouseBookingRequestsTable;
use App\Models\GuesthouseBookingRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GuesthouseBookingRequestResource extends Resource
{
    protected static ?string $model = GuesthouseBookingRequest::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Bookings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return GuesthouseBookingRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GuesthouseBookingRequestsTable::configure($table);
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
            'index' => ListGuesthouseBookingRequests::route('/'),
            'create' => CreateGuesthouseBookingRequest::route('/create'),
            'edit' => EditGuesthouseBookingRequest::route('/{record}/edit'),
        ];
    }
}
