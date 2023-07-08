<?php

use App\Http\Controllers\Api\HandlerController;
use App\Http\Controllers\Api\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('test', [TestController::class, 'test']);

Route::prefix('handlers')->name('handlers.')->group(function () {
    Route::get('/', [HandlerController::class, 'index'])->name('index');
    Route::post('/', [HandlerController::class, 'store'])->name('store');
    Route::get('/{key}', [HandlerController::class, 'show'])->name('show');
    Route::delete('/{key}', [HandlerController::class, 'delete'])->name('delete');
});
