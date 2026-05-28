<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                 TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('name')
                    ->label('Име')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('email')
                    ->label('Имейл')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Имейлът е копиран'),
                
                // TextColumn::make('role')
                //     ->label('Роля')
                //     ->badge()
                //     ->color(fn (string $state): string => match ($state) {
                //         'admin' => 'danger',
                //         'editor' => 'warning',
                //         'viewer' => 'success',
                //         default => 'gray',
                //     })
                //     ->formatStateUsing(fn (string $state): string => match ($state) {
                //         'admin' => 'Администратор',
                //         'editor' => 'Редактор',
                //         'viewer' => 'Наблюдател',
                //         default => $state,
                //     })
                //     ->sortable(),
                
                // IconColumn::make('email_verified_at')
                //     ->label('Потвърден')
                //     ->boolean()
                //     ->trueIcon('heroicon-o-check-badge')
                //     ->falseIcon('heroicon-o-x-circle')
                //     ->trueColor('success')
                //     ->falseColor('danger')
                //     ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Създаден')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('updated_at')
                    ->label('Обновен')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
