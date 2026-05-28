<?php

namespace App\Filament\Resources\LocationHistories\Pages;

use App\Filament\Resources\LocationHistories\LocationHistoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLocationHistory extends ViewRecord
{
    protected static string $resource = LocationHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
