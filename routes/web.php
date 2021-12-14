<?php

use App\Http\Controllers\RegulationController;
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


Route::get('/regulations', [RegulationController::class, 'index'])->name('regulations.index');
Route::get('/regulations/create', [RegulationController::class, 'create'])->name('regulations.create');
Route::post('/regulations', [RegulationController::class, 'store'])->name('regulations.store');

Route::get('/{any}', function () {
    return redirect()->route('regulations.index');
})->where('any', ".*");
