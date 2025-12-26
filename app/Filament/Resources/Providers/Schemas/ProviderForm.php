<?php

namespace App\Filament\Resources\Providers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('telefono')
                    ->tel()
                    ->required()
                    ->numeric(),
                TextInput::make('direccion')
                    ->required(),
                TextInput::make('especialidad')
                    ->required(),
                Toggle::make('activo')
                    ->required(),
            ]);
    }
}
