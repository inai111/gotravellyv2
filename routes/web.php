<?php

use App\Exports\CitiesExport;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CobaController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\States;
use Illuminate\Support\Facades\Storage;

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
const CREATE_POST = '/create';

Route::get('/',[CobaController::class,'index'])->name('home')->middleware('auth');

/**
 * url untuk awalan city
 */
Route::group([
    'prefix'=>'cities',
    'middleware'=>['auth'],
    'where'=>['id'=>'[0-9]+']
    ],function(){
        Route::get('/{id}',[CobaController::class,'detailcity']);
        Route::get('/{id}/edit',[CobaController::class,'editcity']);
        Route::get(CREATE_POST,[CobaController::class,'createcity'])->name('cities.create');
        Route::post(CREATE_POST,[CobaController::class,'storecity'])->name('cities.store');
        Route::put('/{id}/edit',[CobaController::class,'updatecity']);
        Route::delete('/{id}/delete',[CobaController::class,'deletecity']);
    }
);

/**
 * url untuk state
 */
Route::group([
    'prefix'=>'state',
    'middleware'=>['auth'],
    'where'=>['id'=>'[0-9]+']
    ],function(){
        Route::get('/{state}',[CobaController::class,'detailstate']);
        Route::get('/{state}/edit',[CobaController::class,'editstate'])->name('state.edit');
        Route::get(CREATE_POST,[CobaController::class,'createstate'])->name('state.create');
        Route::post(CREATE_POST,[CobaController::class,'storestate'])->name('state.store');
        Route::put('/{state}/edit',[CobaController::class,'updatestate']);
        Route::delete('/{state}/delete',[CobaController::class,'deletestate'])->name('state.delete');
    }
);

/**
 * url untuk awalan country
 */
Route::group([
    'prefix'=>'country',
    'middleware'=>['auth'],
    'where'=>['id'=>'[0-9]+']
],function(){
    Route::get('/{country}',[CobaController::class,'detailcountry'])->name('country.show');
    Route::get(CREATE_POST,[CobaController::class,'createcountry']);
    Route::post(CREATE_POST,[CobaController::class,'createcountry']);
    Route::get('/{country}/create',[CobaController::class,'createstate'])->name('country.create.state');
    Route::post('/{country}/create',[CobaController::class,'storestate']);
    Route::get('/{id}/edit',[CobaController::class,'editcountry']);
    Route::put('/{id}/edit',[CobaController::class,'updatecountry']);
    Route::delete('/{id}/delete',[CobaController::class,'deletecountry']);
});

Route::get('/logout',function(){
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    $cookie = cookie('token-access','',-1);
    return redirect('/')->with('message', 'You have been logged out!')->withCookie($cookie);
})->middleware('auth')->name('logout');

Route::group(['prefix'=>'login','middleware'=>'guest'],function(){
    Route::get('/',[AuthController::class,'index'])->name('login');
    Route::post('/',[AuthController::class,'login']);
});

Route::group(['prefix'=>'register'],function(){
    Route::get('/',[AuthController::class,'register'])->name('register');
    Route::post('/',[AuthController::class,'registering'])->name('registering');
});

Route::group(['prefix'=>'job'],function(){
    Route::get('/',[JobController::class,'index'])->name('job');
    Route::get('/create',[JobController::class,'create'])->name('job.create');
    Route::post('/',[JobController::class,'store'])->name('job');
});

Route::group(['prefix'=>'upload'],function(){
    Route::post('/',function(){
        $image = request()->file('logo')->store('tempfiles');
        $getMime = Storage::mimeType($image);
        
        $urlImage = Storage::path($image);
        $filename = pathinfo($image, PATHINFO_FILENAME);
        $path = "storage/tempfiles/";
        $new_filename = $path.$filename.'.jpeg';

        $option = [
        	'x'=>request()->post('x'),
        	'y'=>request()->post('y'),
        	'width'=>request()->post('width'),
        	'height'=>request()->post('height'),
        ];

        switch($getMime){
            case "image/png":
                $sourceimg = @imagecreatefrompng($urlImage);
                break;
            case "image/jpeg":
            case "image/jpg":
            default:
                $sourceimg = @imagecreatefromjpeg('.'.$image);
            break;
        }
        $sourceimg = imagecrop($sourceimg,$option);
        imagedestroy($sourceimg);
        imagejpeg($sourceimg,$new_filename,100);

        return response()->json([
            'url'=>asset($new_filename),
        ]);
    });
});


Route::delete('/excel', function (Request $request) {
    return Excel::download(new CitiesExport,
    'invoices.xlsx',\Maatwebsite\Excel\Excel::XLSX, ['X-Vapor-Base64-Encode' => 'True']);
});

// Route::middleware('javascript-allowed')->prefix('collections')->group(function(){
Route::prefix('collections')->group(function(){
    Route::get('/states',[CollectionController::class,'getstates']);
    Route::get('/continents',[CollectionController::class,'getcontinents']);
    Route::get('/countries',[CollectionController::class,'getcountries']);
});

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
