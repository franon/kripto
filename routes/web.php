<?php

use App\Http\Controllers\Drive\SimpleDrive;
use App\Http\Controllers\Employee\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\enkripsirsa;
use App\Http\Controllers\KriptoTemp1;
use App\Http\Controllers\sha256;
use App\Http\Controllers\Encryption;
use App\Http\Controllers\UploadController;

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

Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->namespace('dashboard')->group(function(){
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // Route::get('/admin', [,'']);
        // Route::get('/employee', [,'']);
    });

    Route::prefix('employee')->namespace('employee')->group(function(){
        Route::get('dashboard',[EmployeeController::class,'index']);

        Route::get('upload', [UploadController::class, 'upload']);
        Route::post('upload/process', [UploadController::class, 'upload_process']);

        Route::get('drive', [SimpleDrive::class, 'showFiles']);
    });

});

require __DIR__.'/auth.php';
