<?php

namespace App\Filament\Resources\LocationHistories\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LocationHistoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 TextInput::make('lat')
                    ->label('Геогр. ширина')
                    ->required()
                    ->numeric()
                    ->step(0.00000001),
                
                TextInput::make('lng')
                    ->label('Геогр. дължина')
                    ->required()
                    ->numeric()
                    ->step(0.00000001),
                
                TextInput::make('distance_km')
                    ->label('Изминати км')
                    ->numeric()
                    ->step(0.1)
                    ->minValue(0)
                    ->maxValue(133),
                
                TextInput::make('speed')
                    ->label('Скорост (км/ч)')
                    ->numeric()
                    ->step(0.1),
                
                TextInput::make('battery')
                    ->label('Батерия (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100),
                
                TextInput::make('accuracy')
                    ->label('Точност (м)')
                    ->numeric(),
                
                TextInput::make('device_id')
                    ->label('ID на устройство')
                    ->maxLength(255),
                
                DateTimePicker::make('recorded_at')
                    ->label('Време на запис')
                    ->required()
                    ->default(now()),
            ]);
    }
}
