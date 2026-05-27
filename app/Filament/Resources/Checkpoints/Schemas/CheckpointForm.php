<?php

namespace App\Filament\Resources\Checkpoints\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CheckpointForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 TextInput::make('name')
                    ->label('Име')
                    ->required()
                    ->maxLength(255),
                TextInput::make('lat')
                    ->label('Географска ширина')
                    ->required()
                    ->numeric()
                    ->step(0.00000001),
                TextInput::make('lng')
                    ->label('Географска дължина')
                    ->required()
                    ->numeric()
                    ->step(0.00000001),
                TextInput::make('distance_km')
                    ->label('Разстояние от Ямбол (км)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(133),
                TextInput::make('order_position')
                    ->label('Ред на точката')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
