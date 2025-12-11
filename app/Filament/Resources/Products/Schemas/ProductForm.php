<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('precio_compra')
                    ->required()
                    ->numeric(),
                TextInput::make('precio_venta')
                    ->required()
                    ->numeric(),
                TextInput::make('dias_caducidad')
                    ->required()
                    ->numeric(),
                Select::make('provider_id')
                    ->relationship('provider', 'nombre')
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'nombre')
                    ->required(),
            ]);
    }
}
