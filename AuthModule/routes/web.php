<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AcademyController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

// Rutas de perfil
Route::get('profile', 'App\Http\Controllers\ProfileController@edit')->name('profile.edit');
Route::put('profile', 'App\Http\Controllers\ProfileController@update')->name('profile.update');
Route::delete('/profile/deactivate/{user}', 'App\Http\Controllers\ProfileController@deactivate')->name('profile.deactivate');


//home
Route::get('/home', [AcademyController::class, 'mostrarAcademia'])->name('home');


//ruta categroias

Route::get('/academy/{ruta_categoria}', [AcademyController::class, 'mostrarCategorias'])
    ->middleware(['verified'])
    ->name('academy');

//plan
Route::get('/plan', function () {
    return view('plan');
});


// Ruta de usuarios (esta ruta es la que tgenia para usuarios reemplazala por lo tuyo)
Route::get('/usuarios', function () {
    $user = auth()->user(); // Obtener el usuario autenticado
    return view('usuarios', compact('user'));
})->middleware('verified')->name('usuarios');


// Route::resource('/crud', [CrudController::class]);
// Route::get('/xxx', [XController::class]); //solo si tienes un metodo para no especificar
