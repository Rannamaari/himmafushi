<?php

namespace App\Filament\Resources\HomepageFeatures;

use App\Filament\Resources\HomepageFeatures\Pages\CreateHomepageFeature;
use App\Filament\Resources\HomepageFeatures\Pages\EditHomepageFeature;
use App\Filament\Resources\HomepageFeatures\Pages\ListHomepageFeatures;
use App\Models\HomepageFeature;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HomepageFeatureResource extends Resource
{
    protected static ?string $model = HomepageFeature::class;

    protected static ?string $navigationLabel = 'Featured Tiles';

    protected static string|\UnitEnum|null $navigationGroup = 'Homepage';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->columnSpanFull(),
            TextInput::make('type_label')->label('Content type')->placeholder('Restaurant, experience, transfer...'),
            TextInput::make('badge')->placeholder('Featured, popular, special...'),
            Textarea::make('summary')->rows(4)->columnSpanFull(),
            FileUpload::make('image')->image()->disk('public')->directory('homepage/features')->imageEditor()->columnSpanFull(),
            TextInput::make('price_text')->label('Price or footer text')->placeholder('USD 25 or Book direct'),
            TextInput::make('cta_label')->label('Button label')->default('View')->required(),
            TextInput::make('url')->label('Destination URL')->required()->columnSpanFull()->helperText('Use a site path such as /restaurants/moscow-yeda or a complete external URL.'),
            TextInput::make('sort_order')->numeric()->default(0)->required(),
            DateTimePicker::make('starts_at')->seconds(false), DateTimePicker::make('ends_at')->seconds(false),
            Toggle::make('active')->default(true)->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort_order')->columns([
            ImageColumn::make('image')->disk('public')->square(), TextColumn::make('title')->searchable(),
            TextColumn::make('type_label')->label('Type')->badge(), TextColumn::make('badge')->badge(),
            TextColumn::make('sort_order')->numeric()->sortable(), TextColumn::make('starts_at')->dateTime()->sortable(),
            TextColumn::make('ends_at')->dateTime()->sortable(), IconColumn::make('active')->boolean(),
        ])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ListHomepageFeatures::route('/'), 'create' => CreateHomepageFeature::route('/create'), 'edit' => EditHomepageFeature::route('/{record}/edit')];
    }
}
