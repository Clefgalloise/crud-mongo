<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ImageController;
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

Route::get('images', [ImageController::class, 'index'])->name('images');
Route::get('images/{any}', [ImageController::class, 'index'])->where('any', '.*');

Route::resource('{collection}', CollectionController::class)->parameters([
    '{collection}' => 'id'
]);
