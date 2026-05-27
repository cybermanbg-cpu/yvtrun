<?php

namespace App\Filament\Resources\YouTubeVideos\Pages;

use App\Filament\Resources\YouTubeVideos\YouTubeVideoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListYouTubeVideos extends ListRecords
{
    protected static string $resource = YouTubeVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
