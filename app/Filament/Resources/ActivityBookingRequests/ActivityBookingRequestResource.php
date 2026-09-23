<?php

namespace App\Filament\Resources\ActivityBookingRequests;

use App\Filament\Resources\ActivityBookingRequests\Pages\EditActivityBookingRequest;
use App\Filament\Resources\ActivityBookingRequests\Pages\ListActivityBookingRequests;
use App\Filament\Resources\ActivityBookingRequests\Schemas\ActivityBookingRequestForm;
use App\Filament\Resources\ActivityBookingRequests\Tables\ActivityBookingRequestsTable;
use App\Models\ActivityBookingRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ActivityBookingRequestResource extends Resource
{
    protected static ?string $model = ActivityBookingRequest::class;

    protected static ?string $navigationLabel = 'Excursion Bookings';

    protected static string|\UnitEnum|null $navigationGroup = 'Bookings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ActivityBookingRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivityBookingRequestsTable::configure($table);
    }

    public static function getPages(): array
    {
        return ['index' => ListActivityBookingRequests::route('/'), 'edit' => EditActivityBookingRequest::route('/{record}/edit')];
    }
}
