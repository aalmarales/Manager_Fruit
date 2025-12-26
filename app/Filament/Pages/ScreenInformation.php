<?php

namespace App\Filament\Pages;

//use Filament\Pages\Page;

use App\Filament\Resources\Products\Widgets\ProductChart;
use App\Filament\Resources\Products\Widgets\ProductOverview;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Support\Icons\Heroicon;


class ScreenInformation extends Page
{
    protected string $view = 'volt-livewire::filament.pages.screen-information';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Home ;

     public function getHeaderWidgets(): array
    {
        return [
            ProductOverview::class,
            ProductChart::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 4;
    }
}
