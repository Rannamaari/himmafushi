<?php

namespace App\Filament\Resources\Articles\Tables;

use App\Models\Article;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->searchable(), TextColumn::make('category.name')->label('Category')->badge(), TextColumn::make('slug')->searchable(), TextColumn::make('published_at')->dateTime()->sortable(),
            TextColumn::make('publication_status')->label('Website status')->state(fn (Article $record): string => ! $record->active ? 'Hidden' : ($record->published_at?->isFuture() ? 'Scheduled' : ($record->published_at ? 'Published' : 'Publish date missing')))->badge()->color(fn (Article $record): string => ! $record->active ? 'gray' : ($record->published_at?->isFuture() ? 'warning' : ($record->published_at ? 'success' : 'danger'))),
            IconColumn::make('featured')->boolean(), IconColumn::make('active')->boolean(),
        ])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
