<?php

namespace App\Filament\Resources\LocationHistories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LocationHistoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                 TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('lat')
                    ->label('Ширина')
                    ->formatStateUsing(fn ($state) => number_format($state, 6))
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('lng')
                    ->label('Дължина')
                    ->formatStateUsing(fn ($state) => number_format($state, 6))
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('distance_km')
                    ->label('Изминати км')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1) . ' км' : '-')
                    ->sortable()
                    ->alignCenter(),
                
                TextColumn::make('speed')
                    ->label('Скорост')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1) . ' км/ч' : '-')
                    ->sortable()
                    ->alignCenter(),
                
                IconColumn::make('battery')
                    ->label('Батерия')
                    ->icon(fn ($state): string => match (true) {
                        $state >= 75 => 'heroicon-o-battery-100',
                        $state >= 50 => 'heroicon-o-battery-50',
                        $state >= 25 => 'heroicon-o-battery-50',
                        $state >= 0 => 'heroicon-o-battery-0',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->color(fn ($state): string => match (true) {
                        $state >= 50 => 'success',
                        $state >= 20 => 'warning',
                        $state >= 0 => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                
                TextColumn::make('accuracy')
                    ->label('Точност')
                    ->formatStateUsing(fn ($state) => $state ? $state . ' м' : '-')
                    ->sortable(),
                
                TextColumn::make('device_id')
                    ->label('Устройство')
                    ->searchable()
                    ->limit(20)
                    ->toggleable(),
                
                TextColumn::make('recorded_at')
                    ->label('Време')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->defaultSort('recorded_at', 'desc');
    }
}
