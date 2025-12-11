<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_logs', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignIdFor(Product::class)->cascadeOnDelete();
            $table->decimal('stock_inicial');
            $table->decimal('compras_dia');
            $table->decimal('ventas_dia');
            $table->decimal('mermas_dia');
            $table->decimal('stock_final');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_logs');
    }
};
