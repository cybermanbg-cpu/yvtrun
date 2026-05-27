<?php

namespace App\Filament\Resources\YouTubeVideos\Pages;

use App\Filament\Resources\YouTubeVideos\YouTubeVideoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateYouTubeVideo extends CreateRecord
{
    protected static string $resource = YouTubeVideoResource::class;
}
