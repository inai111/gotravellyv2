<?php

use App\Exports\CategoriesExport;
use App\Exports\CitiesExport;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CobaController;
use App\Http\Resources\V1\CityCollection;
use App\Models\Categories;
use App\Models\Cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[CobaController::class,'index'])->name('user');

Route::group(['prefix'=>'login'],function(){
    Route::get('/',[AuthController::class,'index'])->name('login');
    Route::post('/',[AuthController::class,'login']);
});

Route::delete('/excel', function (Request $request) {
    // return view('exports.cities',['data'=>new CityCollection(Cities::all())]);
    return Excel::download(new CitiesExport,'invoices.xlsx',\Maatwebsite\Excel\Excel::XLSX, ['X-Vapor-Base64-Encode' => 'True']);
});

// Route::middleware('javascript-allowed')->group(['prefix'=>'collections'],function(){
//     Route::get('/cities',[CollectionController::class,'getcities']);
// })

Route::get('/setup', function() {
    $credentials = [
        'email' => 'admin@admin.com',
        'password' => "password"
    ];

    if (!Auth::attempt($credentials)) {
        $user = new \App\Models\User();
        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);

        $user->save();
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete']);
            $updateToken = $user->createToken('update-token', ['create', 'update']);
            $basicToken = $user->createToken('basic-token');

            return [
                'admin' => $adminToken->plainTextToken,
                'update' => $updateToken->plainTextToken,
                'basic' => $basicToken->plainTextToken
            ];
        }
    }
});
