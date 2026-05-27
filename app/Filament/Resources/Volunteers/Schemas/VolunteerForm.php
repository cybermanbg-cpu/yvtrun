<?php

namespace App\Filament\Resources\Volunteers\Schemas;

use App\Models\Volunteer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VolunteerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 TextInput::make('name')
                    ->label('Име')
                    ->required()
                    ->maxLength(255),
                Select::make('role')
                    ->label('Роля')
                    ->options(Volunteer::getRoles())
                    ->required(),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->required()
                    ->maxLength(20),
                Select::make('time_slot')
                    ->label('Часова смяна')
                    ->options([
                        '06:00-10:00' => '06:00 - 10:00',
                        '10:00-14:00' => '10:00 - 14:00',
                        '14:00-18:00' => '14:00 - 18:00',
                        '18:00-22:00' => '18:00 - 22:00',
                        '22:00-02:00' => '22:00 - 02:00',
                    ])
                    ->required(),
                TextInput::make('checkpoint_location')
                    ->label('Контролна точка')
                    ->maxLength(255),
                Textarea::make('additional_info')
                    ->label('Допълнителна информация')
                    ->rows(3),
                Toggle::make('confirmed')
                    ->label('Потвърден')
                    ->default(false),
            ]);
    }
}
