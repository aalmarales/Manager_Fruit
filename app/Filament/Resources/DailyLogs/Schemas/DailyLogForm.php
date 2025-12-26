<?php

namespace App\Filament\Resources\DailyLogs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DailyLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('fecha')
                    ->required(),
                Select::make('product_id')
                    ->relationship('product', 'nombre')
                    ->required(),
                TextInput::make('stock_inicial')
                    ->required()
                    ->numeric(),
                TextInput::make('compras_dia')
                    ->required()
                    ->numeric(),
                TextInput::make('ventas_dia')
                    ->required()
                    ->numeric(),
                TextInput::make('mermas_dia')
                    ->required()
                    ->numeric(),
                TextInput::make('stock_final')
                    ->required()
                    ->numeric(),
            ]);
    }
}
