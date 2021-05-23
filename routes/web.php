<?php

use App\Http\Controllers\Employee\Drive\SimpleDrive;
use App\Http\Controllers\Employee\Drive\FileProcessing;
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
        })->name('dashboard-default');

        // Route::get('/admin', [,'']);
        // Route::get('/employee', [,'']);
    });

    Route::prefix('employee')->name('employee.')->group(function(){
        Route::get('dashboard',[EmployeeController::class,'index'])->name('dashboard');

        Route::get('upload', [UploadController::class, 'upload']);
        Route::post('upload/process', [UploadController::class, 'upload_process']);

        Route::get('drive', [SimpleDrive::class, 'showFiles'])->name('drive');
        Route::get('drive/{filename}', [SimpleDrive::class, 'downloadFiles'])->name('drive.file.download');
        Route::get('drive/remove/{filename}', [SimpleDrive::class, 'removeFiles'])->name('drive.file.remove');

        Route::get('file/encrypt', [FileProcessing::class, 'show_FileEncryption'])->name('file.encrypt');
        Route::post('file/encrypt/upload', [FileProcessing::class, 'process_FileEncryption'])->name('file.encrypt.upload');
        Route::get('file/decrypt', [FileProcessing::class, 'show_FileDecryption'])->name('file.decrypt');
        Route::post('file/decrypt/upload', [FileProcessing::class, 'process_FileDecryption'])->name('file.decrypt.upload');
        Route::get('file/decrypt/download/{filename}', [FileProcessing::class, 'process_DownloadFileDecryption'])->name('file.decrypt.download');
    });

});

require __DIR__.'/auth.php';
