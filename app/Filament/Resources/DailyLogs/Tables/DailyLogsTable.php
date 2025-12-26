<?php

namespace App\Filament\Resources\DailyLogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use Filament\Actions\ImportAction;
use App\Filament\Imports\DailyLogImporter;

use Illuminate\Validation\Rules\File;

use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;

class DailyLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->headerActions([
            ImportAction::make()
            ->importer(DailyLogImporter::class)
            ->label('Importar Registro Diario')
            ->color('blue')
            ->icon('heroicon-o-circle-stack')
            
            /* ->fileRules([
                File::types(['csv','txt', 'xlsx'])
            ]) */

        ])
            ->columns([
                TextColumn::make('fecha')
                    ->date()
                    ->badge(),
                    //->sortable(),
                TextColumn::make('product.nombre')
                    ->searchable()
                    ->badge(),
                TextColumn::make('stock_inicial')
                    ->numeric(),
                    //->badge(),
                    //->sortable(),
                TextColumn::make('compras_dia')
                    ->numeric(),
                    //->badge(),
                    //->sortable(),
                TextColumn::make('ventas_dia')
                    ->numeric(),
                    //->badge(),
                    //->sortable(),
                TextColumn::make('mermas_dia')
                    ->numeric(),
                    //->badge(),
                    //->sortable(),
                TextColumn::make('stock_final')
                    ->numeric()
                    ->badge(),
                    //->sortable(),
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
                    //EditAction::make(),
                    //DeleteAction::make()
                ])
               
            ])
            ->toolbarActions([
                /* BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]), */
            ])
            ->defaultGroup('product.nombre');
             

    }
}
