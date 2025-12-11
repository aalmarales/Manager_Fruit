<?php

namespace App\Filament\Resources\Providers\Widgets;

use App\Models\Provider;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProviderOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
           Stat::make('Count:  '.'✅', Provider::count())
             ->description('General Information')
             ->color('success'),
        ];
    }
}
