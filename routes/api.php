<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/error', [\App\Http\Controllers\HomeController::class, 'error']);


Route::middleware(['auth','json'])
    ->group(function () {
        Route::prefix('tags')->group(function () {
            Route::get('', [\App\Http\Controllers\TagController::class, 'index']);
            Route::get("{id}", [\App\Http\Controllers\TagController::class, 'show']);
            Route::post('', [\App\Http\Controllers\TagController::class, 'store']);
            Route::put('{id}', [\App\Http\Controllers\TagController::class, 'update']);
            Route::delete("{id}", [\App\Http\Controllers\TagController::class, 'destroy']);
        });

        Route::prefix('contacts')->group(function () {
            Route::post('import',[\App\Http\Controllers\ContactController::class,'import'])->withoutMiddleware('json');
            Route::get('export',[\App\Http\Controllers\ContactController::class,'export'])->withoutMiddleware('json');

            Route::get('', [\App\Http\Controllers\ContactController::class, 'index']);
            Route::get("{id}", [\App\Http\Controllers\ContactController::class, 'show']);
            Route::post('', [\App\Http\Controllers\ContactController::class, 'store']);
            Route::put('{id}', [\App\Http\Controllers\ContactController::class, 'update']);
            Route::delete("{id}", [\App\Http\Controllers\ContactController::class, 'destroy']);
            });
    });


