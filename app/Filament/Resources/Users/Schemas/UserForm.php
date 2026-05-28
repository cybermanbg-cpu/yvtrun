<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Име')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('email')
                    ->label('Имейл')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                
                TextInput::make('password')
                    ->label('Парола')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->maxLength(255),
                
                // Select::make('role')
                //     ->label('Роля')
                //     ->options([
                //         'admin' => 'Администратор',
                //         'editor' => 'Редактор',
                //         'viewer' => 'Наблюдател',
                //     ])
                //     ->default('viewer')
                //     ->required(),
            ]);
    }
}
