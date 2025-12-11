<?php

namespace App\Filament\Resources\Products\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProductChart extends ChartWidget
{
    protected ?string $heading = 'ESTADISTICA POR DIA...';

    

    protected function getData(): array
    {

        $data = Trend::model(Product::class)
                ->between(
                    start: now()->startOfMonth(),
                    end: now()->endOfMonth()
                    )
                ->perDay()
                ->count();

        return [
            'datasets' => [
            [
                'label' => 'Products Stats',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
