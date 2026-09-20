<?php

namespace App\Filament\Resources\TransferBookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransferBookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')
                    ->searchable(),
                TextColumn::make('transfer.name')
                    ->searchable(),
                TextColumn::make('customer_type')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('whatsapp')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('country')
                    ->searchable(),
                TextColumn::make('travel_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('preferred_time')
                    ->searchable(),
                TextColumn::make('passengers')
                    ->label('Guests (3+)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('infants')
                    ->label('Infants (0-2)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('flight_number')
                    ->searchable(),
                TextColumn::make('flight_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('pickup_location')
                    ->searchable(),
                TextColumn::make('dropoff_location')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('quote_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quote_currency')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
