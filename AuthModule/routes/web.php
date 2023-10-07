<?php

use App\Http\Controllers\InicioControlador;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Route::get('/', function () {

//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\InicioControlador::class, 'index']);



Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('verified');

Route::get('/usuarios', function () {
    $plans = app(InicioControlador::class)->planes();
    $user = auth()->user(); // Obtener el usuario autenticado
    return view('usuarios', compact('user', 'plans'));
})->middleware('verified');

//RUTAS ACTUALIZACION
Route::get('profile', 'App\Http\Controllers\ProfileController@edit')->name('profile.edit');
Route::put('profile', 'App\Http\Controllers\ProfileController@update')->name('profile.update');

Route::delete('/profile/deactivate/{user}', 'App\Http\Controllers\ProfileController@deactivate')->name('profile.deactivate');

Route::post('/suscription/suscribirse', 'App\Http\Controllers\SubscriptionController@suscribirse')->name('suscription.suscribirse');


Route::get('/planes', [InicioControlador::class, 'planes']);


Route::get('/usuarios', function () {
    $plans = app(InicioControlador::class)->planes();
    $user = auth()->user(); // Obtener el usuario autenticado
    return view('usuarios', compact('user', 'plans'));
})->middleware('verified')->name('usuarios');



Route::get('/usuarios', function () {
    $plans = app(InicioControlador::class)->planes();
    $user = auth()->user(); // Obtener el usuario autenticado
    return view('usuarios', compact('user', 'plans'));
})->middleware('verified')->name('usuarios');

// Route::prefix('subscribe')
//     ->name('subscribe.')
//     ->group(function () {
//         Route::get('/', 'App\Http\Controllers\SubscriptionController@show')
//             ->name('show');

//         Route::post('/', 'App\Http\Controllers\SubscriptionController@store')
//             ->name('store');
//         Route::post('/approval', 'App\Http\Controllers\SubscriptionController@approval')
//             ->name('approval');
//         Route::post('/cancelled', 'App\Http\Controllers\SubscriptionController@cancelled')
//             ->name('cancelled');
//     });
