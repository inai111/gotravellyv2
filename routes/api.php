<?php

use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\CountriesController;
use App\Http\Controllers\Api\V1\ContinentsController;
use App\Http\Controllers\Api\V1\CitiesController;
use App\Http\Controllers\Api\V1\StatesController;
use App\Http\Controllers\Api\V1\CategoriesController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Models\Customer;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// api/v1/
// Route::group(['prefix' => 'v1', 'namespace', 'App\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function() {
//     Route::apiResource('customers', CustomerController::class);
//     Route::apiResource('invoices', InvoiceController::class);

//     Route::post('invoices/bulk', [InvoiceController::class, 'bulkStore']);
// });

Route::middleware('auth:sanctum')->prefix('v1')->group(function() {
    Route::apiResource('customers', CustomerController::class)->names([]);
    Route::apiResource('invoices', InvoiceController::class)->names([]);
    Route::apiResource('continents', ContinentsController::class)->names([]);
    Route::apiResource('countries', CountriesController::class)->names([]);
    Route::apiResource('states', StatesController::class)->names([
        'index'     =>'v1.states.index',
        'store'     =>'v1.states.store',
        'update'    =>'v1.states.update',
        'destroy'   =>'v1.states.destroy',    
    ]);
    Route::apiResource('cities', CitiesController::class)->names([
        'index'     =>'v1.cities.index',
        'store'     =>'v1.cities.store',
        'update'    =>'v1.cities.update',
        'destroy'   =>'v1.cities.destroy',    
    ]);
    Route::apiResource('categories', CategoriesController::class)->names([]);
    
    Route::post('invoices/bulk', [InvoiceController::class, 'bulkStore']);
    Route::post('countries/bulk', [CountriesController::class, 'storebulk']);
    Route::post('continents/bulk', [ContinentsController::class,'storebulk']);
    Route::post('states/bulk', [StatesController::class,'storebulk']);
    Route::post('cities/bulk', [CitiesController::class,'storebulk'])->name('api.cities.bulk');
    Route::post('categories/bulk', [CategoriesController::class,'storebulk']);
    // })->middleware('add-etag');
});

Route::prefix('v1')->group(function() {
    Route::post('login', [AuthController::class, 'index'])->name('v1.login');
});