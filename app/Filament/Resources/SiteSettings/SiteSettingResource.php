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

    protected static ?string $navigationLabel = 'Integration Settings';

    protected static ?string $modelLabel = 'integration setting';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('label')->disabled()->dehydrated(),
            TextInput::make('key')->disabled()->dehydrated(),
            TextInput::make('value')->visible(fn (?SiteSetting $record): bool => ! $record?->is_secret)->helperText(fn (?SiteSetting $record): string => match ($record?->key) {
                'google_analytics_id' => 'Example: G-XXXXXXXXXX',
                'google_tag_manager_id' => 'Example: GTM-XXXXXXX',
                'adsense_publisher_id' => 'Example: ca-pub-XXXXXXXXXXXXXXXX',
                'telegram_transfer_chat_id', 'telegram_guesthouse_chat_id', 'telegram_newsletter_chat_id', 'telegram_excursion_chat_id' => 'Enter the numeric chat ID, including a leading minus sign when applicable.',
                default => 'Enter the integration value.',
            }),
            TextInput::make('secret_value')->label('Secret value')->password()->revealable()->visible(fn (?SiteSetting $record): bool => (bool) $record?->is_secret)->helperText('Stored encrypted in the database.'),
            Toggle::make('active')->helperText('This integration is only used when enabled and configured.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('group')->badge()->sortable(), TextColumn::make('label'),
            TextColumn::make('configured')->state(fn (SiteSetting $record): string => ($record->is_secret ? $record->secret_value : $record->value) ? 'Configured' : 'Not configured')->badge(),
            IconColumn::make('active')->boolean(),
        ])->defaultGroup('group')->recordActions([EditAction::make()]);
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
