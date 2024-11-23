<?php

use App\Http\Controllers\DirectorioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/directorio/index', [DirectorioController::class, 'index'])->name('directorio.index');
    Route::post('/directorio/register', [DirectorioController::class, 'register'])->name('directorio.register');
    Route::get('/directorio/usuarios', [DirectorioController::class, 'getUsers'])->name('directorio.getUsers');
    Route::post('/directorio/delete', [DirectorioController::class, 'destroy'])->name('directorio.delete');
    Route::get('/directorio/edit', [DirectorioController::class, 'edit'])->name('directorio.edit');
    Route::post('/directorio/update', [DirectorioController::class, 'update'])->name('directorio.update');



});
