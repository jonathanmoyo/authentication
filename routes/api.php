<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\authController;
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

//Route::post('/products',function (){
//   return Product::create([
//       'name'=>'product two',
//       'slug'=>'product-two',
//       'description'=>'this is product two',
//       'price'=>'299.99'
//   ]);
//});
//Route::resource('/products',ProductController::class);


//public routes
Route::post('/login',[authController::class,'login']);
Route::get('/products/search/{name}',[ProductController::class, 'search']);
Route::post('/register',[authController::class, 'register']);
Route::get('/products/{id}', [ProductController::class, 'show'] );
Route::get('/products', [ProductController::class, 'index'] );



//protected routes
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/products',[ProductController::class,'store']);
    Route::put('/products',[ProductController::class,'update']);
    Route::delete('/products',[ProductController::class,'destroy']);
    Route::post('/logout',[authController::class,'logout']);
});


//
//




//Route::post('/products',function() {
//    return Product::create([ 'name'=> 'product two',
//    'slug'=> 'product-two',
//    'price'=>'299.9',
//    'description'=>'this is product-two'
//]);
//   });


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
