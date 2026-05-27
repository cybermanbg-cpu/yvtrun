<?php

namespace App\Filament\Resources\YouTubeVideos;

use App\Filament\Resources\YouTubeVideos\Pages\CreateYouTubeVideo;
use App\Filament\Resources\YouTubeVideos\Pages\EditYouTubeVideo;
use App\Filament\Resources\YouTubeVideos\Pages\ListYouTubeVideos;
use App\Filament\Resources\YouTubeVideos\Schemas\YouTubeVideoForm;
use App\Filament\Resources\YouTubeVideos\Tables\YouTubeVideosTable;
use App\Models\YouTubeVideo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class YouTubeVideoResource extends Resource
{
    protected static ?string $model = YouTubeVideo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return YouTubeVideoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return YouTubeVideosTable::configure($table);
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
            'index' => ListYouTubeVideos::route('/'),
            'create' => CreateYouTubeVideo::route('/create'),
            'edit' => EditYouTubeVideo::route('/{record}/edit'),
        ];
    }
}
