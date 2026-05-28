<?php

namespace App\Filament\Resources\LocationHistories\Pages;

use App\Filament\Resources\LocationHistories\LocationHistoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLocationHistory extends EditRecord
{
    protected static string $resource = LocationHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
