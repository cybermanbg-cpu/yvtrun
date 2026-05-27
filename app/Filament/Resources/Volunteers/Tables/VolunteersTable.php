<?php

namespace App\Filament\Resources\Volunteers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VolunteersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Име')
                    ->searchable(),
                TextColumn::make('role_name')
                    ->label('Роля'),
                TextColumn::make('phone')
                    ->label('Телефон'),
                TextColumn::make('time_slot')
                    ->label('Смяна'),
                IconColumn::make('confirmed')
                    ->label('Потвърден')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Записан на')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
