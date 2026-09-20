<?php

namespace App\Filament\Resources\TransferBookings;

use App\Filament\Resources\TransferBookings\Pages\CreateTransferBooking;
use App\Filament\Resources\TransferBookings\Pages\EditTransferBooking;
use App\Filament\Resources\TransferBookings\Pages\ListTransferBookings;
use App\Filament\Resources\TransferBookings\Schemas\TransferBookingForm;
use App\Filament\Resources\TransferBookings\Tables\TransferBookingsTable;
use App\Models\TransferBooking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TransferBookingResource extends Resource
{
    protected static ?string $model = TransferBooking::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Bookings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TransferBookingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransferBookingsTable::configure($table);
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
            'index' => ListTransferBookings::route('/'),
            'create' => CreateTransferBooking::route('/create'),
            'edit' => EditTransferBooking::route('/{record}/edit'),
        ];
    }
}
