<?php

use App\Http\Controllers\ProductController;
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
    return redirect('products');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function (){

    Route::resource('comments', \App\Http\Controllers\CommentController::class);
});
Route::resource('products', \App\Http\Controllers\ProductController::class);
Route::post('products/{product}', [\App\Http\Controllers\ProductController::class, 'buy'])->name('products.buy');
// Route::middleware('guest')->group(function (){
// Route::get('/products', [ProductController::class, 'index']);
// Route::get('/products/{id}', [ProductController::class, 'show'])->withoutMiddleware('auth');
// });

require __DIR__.'/auth.php';
