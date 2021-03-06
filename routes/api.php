<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryProductController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['cors']], function () {
/*
* Products
*/
Route::resource('products',ProductController::class,['only'=>['index','show']]);


/*
* Category
*/
Route::resource('categories',CategoryController::class,['only'=>['index','show']]);
Route::resource('categories.products',CategoryProductController::class,['only'=>['index']]);

});

