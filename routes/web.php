<?php

use Illuminate\Support\Facades\Auth;
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
/*
Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', ['middleware' => 'littlegatekeeper', function () {
    return redirect('/contacts');
}]);

Route::get('/admin', function () {
    return view('secretapage.login');
})->name('admin');

Route::post('/secretapage/login/addCredentials', [\App\Http\Controllers\SecretController::class,'addCredentials'])->name('addCredentials');
Route::get('/contacts/export',[\App\Http\Controllers\ContactController::class,'export'])->name('exportContact');
Route::post('/contacts/import',[\App\Http\Controllers\ContactController::class,'import'])->name('importContact');
Route::get("tags/delete/{tag}",[\App\Http\Controllers\TagController::class,'deleteMiddleware'])->middleware(['littlegatekeeper']);

Route::get('/contacts', [\App\Http\Controllers\ContactController::class,'index'])->name('contacts');
Route::post('/contacts', [\App\Http\Controllers\ContactController::class,'store'])->name('storeContact');
Route::get('/contacts/create', [\App\Http\Controllers\ContactController::class,'create'])->name('createContact');
Route::get('/contacts/{id}', [\App\Http\Controllers\ContactController::class,'show'])->name('showContact');
Route::put("/contacts/{id}", [\App\Http\Controllers\ContactController::class,'update'])->name('updateContact');
Route::get('/contacts/{id}/edit', [\App\Http\Controllers\ContactController::class,'edit'])->name('editContact');
Route::delete("/contacts/{id}", [\App\Http\Controllers\ContactController::class,'delete'])->name('deleteContact');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
