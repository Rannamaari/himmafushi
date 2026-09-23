<?php

namespace App\Filament\Resources\ActivityBookingRequests\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivityBookingRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('reference')->searchable(),
            TextColumn::make('activity_name')->label('Excursion')->searchable(),
            TextColumn::make('preferred_date')->date()->sortable(),
            TextColumn::make('participants')->label('Guests')->sortable(),
            TextColumn::make('name')->searchable(),
            TextColumn::make('whatsapp')->searchable(),
            TextColumn::make('nationality')->searchable(),
            TextColumn::make('estimated_total')->money('USD')->placeholder('Confirm rate')->sortable(),
            TextColumn::make('status')->badge()->sortable(),
            TextColumn::make('created_at')->label('Received')->dateTime()->sortable(),
        ])->defaultSort('created_at', 'desc')->recordActions([EditAction::make()]);
    }
}
