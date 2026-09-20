<?php

namespace App\Filament\Resources\NewsletterSubscribers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NewsletterSubscribersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('email')->label('Email address')->searchable()->copyable(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('consented_at')->label('Consent received')->dateTime()->sortable(),
                TextColumn::make('created_at')->label('Signed up')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(['active' => 'Active', 'unsubscribed' => 'Unsubscribed']),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
