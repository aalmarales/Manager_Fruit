<?php

namespace App\Filament\Resources\DailyLogs\Pages;

use App\Filament\Resources\DailyLogs\DailyLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Imports\ImportColumn;

use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;



class ListDailyLogs extends ListRecords
{
    protected static string $resource = DailyLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    function getTabs(): array
    {
        return [
            //'all'=> Tab::make('fgfdg')
        ];
    }


}
