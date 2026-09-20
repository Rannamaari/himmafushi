<?php

namespace App\Filament\Resources\ArticleCategories;

use App\Filament\Resources\ArticleCategories\Pages\CreateArticleCategory;
use App\Filament\Resources\ArticleCategories\Pages\EditArticleCategory;
use App\Filament\Resources\ArticleCategories\Pages\ListArticleCategories;
use App\Models\ArticleCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ArticleCategoryResource extends Resource
{
    protected static ?string $model = ArticleCategory::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Marketing';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(), TextInput::make('slug')->required()->unique(ignoreRecord: true),
            Textarea::make('description')->columnSpanFull(), TextInput::make('sort_order')->numeric()->default(0)->required(),
            Toggle::make('active')->default(true)->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort_order')->columns([
            TextColumn::make('name')->searchable(), TextColumn::make('slug')->searchable(),
            TextColumn::make('articles_count')->counts('articles')->label('Articles'),
            TextColumn::make('sort_order')->numeric()->sortable(), IconColumn::make('active')->boolean(),
        ])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ListArticleCategories::route('/'), 'create' => CreateArticleCategory::route('/create'), 'edit' => EditArticleCategory::route('/{record}/edit')];
    }
}
