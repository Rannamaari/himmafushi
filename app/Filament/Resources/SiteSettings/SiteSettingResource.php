<?php

namespace App\Filament\Resources\SiteSettings;

use App\Filament\Resources\SiteSettings\Pages\EditSiteSetting;
use App\Filament\Resources\SiteSettings\Pages\ListSiteSettings;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationLabel = 'Tracking Settings';

    protected static ?string $modelLabel = 'tracking setting';

    protected static string|\UnitEnum|null $navigationGroup = 'Marketing';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('label')->disabled()->dehydrated(),
            TextInput::make('key')->disabled()->dehydrated(),
            TextInput::make('value')->helperText('Examples: G-XXXXXXXXXX, GTM-XXXXXXX, or ca-pub-XXXXXXXXXXXXXXXX.'),
            Toggle::make('active')->helperText('Tracking is only loaded when this is enabled and a value is entered.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('label'), TextColumn::make('value')->placeholder('Not configured')->copyable(), IconColumn::make('active')->boolean(),
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
        return ['index' => ListSiteSettings::route('/'), 'edit' => EditSiteSetting::route('/{record}/edit')];
    }
}
