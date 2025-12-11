<?php

namespace App\Filament\Resources\Products\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $caducados = (Product::get())->filter(function(Product $prod){

            $fecha_caduc = $prod->created_at->startOfDay()->addDays($prod->dias_caducidad);

            return $fecha_caduc->isPast();
        });

        $por_caducar = (Product::get())->filter(function(Product $prod){

            $fecha_caduc = $prod->created_at->startOfDay()->addDays($prod->dias_caducidad);

            if($fecha_caduc->isPast()){
                return false;
            }

            $dias = now()->startOfDay()->diffInDays($fecha_caduc,false);

            return $dias <=5 && $dias >=0 ;
            
        });

        return [
            Stat::make('CANTIDAD DE PRODUCTOS:  '.'✅', Product::count())
             ->description('General Information')
             ->icon('heroicon-o-building-storefront')
             ->descriptionColor('success'),
             
             Stat::make(' POR CADUCAR:  '.'⚠️', $por_caducar->count())
             ->description('Expire Soon Products')
             ->icon('heroicon-o-bell-snooze')
             ->descriptionColor('warning'),

            Stat::make(' CADUCADOS:  '.'⚠️', $caducados->count())
             ->description('Caducade Products')
             ->icon('heroicon-o-rocket-launch')
             ->descriptionColor('danger'),

            
        ];
    }
}
