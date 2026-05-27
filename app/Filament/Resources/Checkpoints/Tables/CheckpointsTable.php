<?php

namespace App\Filament\Resources\Checkpoints\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CheckpointsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                 TextColumn::make('name')
                    ->label('Име')
                    ->searchable(),
                TextColumn::make('distance_km')
                    ->label('Км от старта')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('order_position')
                    ->label('Ред')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Създадена')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
             ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
