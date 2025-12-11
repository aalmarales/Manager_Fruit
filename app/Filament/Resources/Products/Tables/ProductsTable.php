<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;



class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->badge(),
                TextColumn::make('precio_compra')
                    ->numeric()
                    ->sortable()
                    ->badge(),
                TextColumn::make('precio_venta')
                    ->numeric()
                    ->sortable()
                    ->badge(),
                TextColumn::make('dias_caducidad')
                    ->numeric()
                    //->sortable()
                    ->badge(),
                TextColumn::make('created_at')
                ->label('Caduca en :')
                ->badge()
                ->color(function(Product $record):string {
                
                $dias_restantes = max(0, now()->startOfDay()
                                        ->diffInDays($record->created_at->startOfDay()->addDays($record->dias_caducidad)
                                        ,false));
                    
                   return  match(true)
                    {
                        $dias_restantes <= 3 =>'danger',
                        $dias_restantes <=5 => 'warning',
                        default => 'success'
                    };
                })
                ->formatStateUsing(function(Product $record):string {
                     $dias_restantes = max(0, now()->startOfDay()
                                        ->diffInDays($record->created_at->startOfDay()->addDays($record->dias_caducidad)
                                        ,false));
                    return match(true)
                    {
                        $dias_restantes === 0 => '⚠️'.'CADUCADO'.'⚠️',
                        $dias_restantes <= 5 => '⚠️'.' '. $dias_restantes.' '.'DIAS',
                        default => '✅'.' '.$dias_restantes.' '.'DIAS'

                    };
                }),
                TextColumn::make('provider.nombre')
                    ->searchable()
                    ->badge(),
                TextColumn::make('category.nombre')
                    ->searchable()
                    ->badge(),
                /* TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), */
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ])
                
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
