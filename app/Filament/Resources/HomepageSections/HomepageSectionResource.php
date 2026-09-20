<?php

namespace App\Filament\Resources\HomepageSections;

use App\Filament\Resources\HomepageSections\Pages\EditHomepageSection;
use App\Filament\Resources\HomepageSections\Pages\ListHomepageSections;
use App\Models\HomepageSection;
use BackedEnum;
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

class HomepageSectionResource extends Resource
{
    protected static ?string $model = HomepageSection::class;

    protected static ?string $navigationLabel = 'Featured Section Text';

    protected static string|\UnitEnum|null $navigationGroup = 'Homepage';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('key')->disabled()->dehydrated(), TextInput::make('eyebrow'),
            TextInput::make('title')->required()->columnSpanFull(), Textarea::make('description')->rows(4)->columnSpanFull(),
            TextInput::make('cta_label')->label('Link label'), TextInput::make('cta_url')->label('Link URL'),
            Toggle::make('active')->default(true)->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title'), TextColumn::make('eyebrow'), TextColumn::make('description')->limit(60), IconColumn::make('active')->boolean(),
        ])->recordActions([EditAction::make()]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return ['index' => ListHomepageSections::route('/'), 'edit' => EditHomepageSection::route('/{record}/edit')];
    }
}
