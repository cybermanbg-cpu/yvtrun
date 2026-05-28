<?php

namespace App\Filament\Resources\LocationHistories;

use App\Filament\Resources\LocationHistories\Pages\CreateLocationHistory;
use App\Filament\Resources\LocationHistories\Pages\EditLocationHistory;
use App\Filament\Resources\LocationHistories\Pages\ListLocationHistories;
use App\Filament\Resources\LocationHistories\Pages\ViewLocationHistory;
use App\Filament\Resources\LocationHistories\Schemas\LocationHistoryForm;
use App\Filament\Resources\LocationHistories\Tables\LocationHistoriesTable;
use App\Models\LocationHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LocationHistoryResource extends Resource
{
    protected static ?string $model = LocationHistory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LocationHistoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LocationHistoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLocationHistories::route('/'),
            'create' => CreateLocationHistory::route('/create'),
            'edit' => EditLocationHistory::route('/{record}/edit'),
            'view' => ViewLocationHistory::route('/{record}'),
        ];
    }
}
