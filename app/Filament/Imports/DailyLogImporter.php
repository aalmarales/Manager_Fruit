<?php

namespace App\Filament\Imports;

use App\Models\DailyLog;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

use function Symfony\Component\Clock\now;

class DailyLogImporter extends Importer
{
    protected static ?string $model = DailyLog::class;

    public static function getColumns(): array
    {
        return [
            /* ImportColumn::make('fecha')
                ->requiredMapping()
                ->rules(['date']), */

            ImportColumn::make('product')
                ->requiredMapping()
                ->relationship(resolveUsing:'nombre')
                ->rules(['required','exists:products,nombre']),
            /* ImportColumn::make('stock_inicial')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']), */
            ImportColumn::make('compras_dia')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),

            ImportColumn::make('ventas_dia')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),

            ImportColumn::make('mermas_dia')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            /* ImportColumn::make('stock_final')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']), */
        ];
    }

    public function resolveRecord(): ?DailyLog
    {

        $product = Product::where('nombre',$this->data['product'])->first();

        if(! $product) {return null;}

        //$fecha = Carbon::parse($this->data['fecha'])->format('Y-m-d');
        //$fecha_anterior = Carbon::parse($fecha)->subDay()->format('Y-m-d');

        //Fecha fija
        $fecha = now()->format('Y-m-d');

        $product_anterior = DailyLog::where('product_id',$product->id)
                                    ->where('fecha','<',$fecha)
                                    ->latest('fecha')
                                    ->first();
        

        $stock_inicial = $product_anterior ? $product_anterior->stock_final : 0 ;

        $stock_final = max(0 , ($stock_inicial + $this->data['compras_dia']
                                        - $this->data['ventas_dia'] - $this->data['mermas_dia']));

        
        return DailyLog::updateOrCreate([
            'fecha' => $fecha,
            'product_id' => $product->id
        ],
        [
            'stock_inicial' => $stock_inicial,
            'compras_dia' => $this->data['compras_dia'],
            'ventas_dia' => $this->data['ventas_dia'],
            'mermas_dia' => $this->data['mermas_dia'],
            'stock_final' => $stock_final
        ]);

        /* return DailyLog::query()
            ->where('fecha', $this->data['fecha'])
            ->first(); */

        /* return DailyLog::firstOrNew([
            'fecha'=>$this->data['fecha']
        ]); */

        //return new DailyLog();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your daily log import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
