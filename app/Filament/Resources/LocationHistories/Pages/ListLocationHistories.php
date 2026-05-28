<?php

namespace App\Filament\Resources\LocationHistories\Pages;

use App\Filament\Resources\LocationHistories\LocationHistoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLocationHistories extends ListRecords
{
    protected static string $resource = LocationHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
