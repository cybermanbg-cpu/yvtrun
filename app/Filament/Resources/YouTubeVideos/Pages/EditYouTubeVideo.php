<?php

namespace App\Filament\Resources\YouTubeVideos\Pages;

use App\Filament\Resources\YouTubeVideos\YouTubeVideoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditYouTubeVideo extends EditRecord
{
    protected static string $resource = YouTubeVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
