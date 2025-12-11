<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Product;

use function Illuminate\Support\now;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/ver', function(){

   /* return response()->json((Product::get())->filter(function(Product $prod){

            $fecha_cad = $prod->created_at->startOfDay()->addDays($prod->dias_caducidad);

            if($fecha_cad->isPast()){return false;}

            $dias = now()->startOfDay()->diffInDays($fecha_cad, false);
            
            return $dias <= 5 && $dias >= 0 ;
            
        })); */

  /*  return response()->json($caducade = (Product::get())->filter(function(Product $prod){

            $fecha_caduc = $prod->created_at->startOfDay()->addDays($prod->dias_caducidad);
            
            return $fecha_caduc->isPast();
        })->pluck('nombre')); */
    /* return response()->json(Trend::model(Product::class)
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth()
            )
            ->perDay()->count());  */
});


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
