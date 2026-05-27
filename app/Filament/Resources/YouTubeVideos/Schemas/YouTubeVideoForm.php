<?php

namespace App\Filament\Resources\YouTubeVideos\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class YouTubeVideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Заглавие')
                    ->required()
                    ->maxLength(255),
                TextInput::make('youtube_id')
                    ->label('YouTube ID')
                    ->helperText('Например: dQw4w9WgXcQ от https://www.youtube.com/watch?v=dQw4w9WgXcQ')
                    ->required()
                    ->unique(ignoreRecord: true),
                Toggle::make('is_live')
                    ->label('Лайфстрийм')
                    ->default(false),
                Toggle::make('is_active')
                    ->label('Активно')
                    ->default(true),
                DateTimePicker::make('scheduled_at')
                    ->label('Планирано за'),
                TextInput::make('thumbnail')
                    ->label('Миниатюра (URL)')
                    ->url()
                    ->nullable(),
            ]);
    }
}
