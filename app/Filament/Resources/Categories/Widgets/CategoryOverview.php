<?php

namespace App\Filament\Resources\Categories\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CategoryOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
             Stat::make('Count:  '.'✅', Category::count())
             ->description('General Information')
             ->color('success'),
        ];
    }
}
