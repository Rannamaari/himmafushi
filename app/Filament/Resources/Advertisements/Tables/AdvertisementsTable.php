<?php

namespace App\Filament\Resources\Advertisements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AdvertisementsTable
{
    public static function configure(Table $table): Table
    {
        return $table->defaultSort('priority', 'desc')->columns([
            TextColumn::make('advertiser')->searchable(), TextColumn::make('placement')->badge()->searchable(),
            TextColumn::make('headline')->searchable()->limit(35), TextColumn::make('priority')->numeric()->sortable(),
            TextColumn::make('starts_at')->dateTime()->sortable(), TextColumn::make('ends_at')->dateTime()->sortable(),
            TextColumn::make('impressions')->numeric()->sortable(), TextColumn::make('clicks')->numeric()->sortable(),
            TextColumn::make('ctr')->label('CTR')->state(fn ($record) => $record->impressions ? number_format(($record->clicks / $record->impressions) * 100, 1).'%' : '0%'),
            IconColumn::make('active')->boolean(),
        ])->filters([SelectFilter::make('placement')->options(['home_search_sponsor' => 'Homepage search sponsor', 'home_after_blog' => 'Homepage after blog'])])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
