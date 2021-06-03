<?php

use App\Http\Controllers\Employee\DigitalSignature;
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

Route::get('sha256', [sha256::class, 'test']);

route::get('coba256',[Encryption::class,'cobaenkrip_256']);
route::get('cobarsa',[Encryption::class,'cobaenkrip_RSA']);

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

        Route::get('drive', [SimpleDrive::class, 'showDirectory'])->name('drive');
        Route::get('drive/{directory}', [SimpleDrive::class, 'showFiles'])->name('drive.directory');
        Route::get('drive/download/{penentu}/{filename}', [SimpleDrive::class, 'downloadFiles'])->name('drive.file.download');
        Route::get('drive/remove/{filename}', [SimpleDrive::class, 'removeFiles'])->name('drive.file.remove');

        Route::prefix('file')->name('file.')->group(function(){
            Route::get('encrypt', [FileProcessing::class, 'show_FileEncryption'])->name('encrypt');
            Route::post('encrypt/upload', [FileProcessing::class, 'process_FileEncryption'])->name('encrypt.upload');
            Route::get('decrypt', [FileProcessing::class, 'show_FileDecryption'])->name('decrypt');
            Route::post('decrypt/upload', [FileProcessing::class, 'process_FileDecryption'])->name('decrypt.upload');
            Route::get('decrypt/download/{filename}', [FileProcessing::class, 'process_DownloadFileDecryption'])->name('decrypt.download');

            Route::get('sign', [DigitalSignature::class, 'show_FormSign'])->name('sign');
            Route::post('sign/process', [DigitalSignature::class, 'createSign'])->name('sign.upload');
            Route::get('verify', [DigitalSignature::class, 'show_FormVerify'])->name('verify');
            Route::post('verify/process', [DigitalSignature::class, 'verifySign'])->name('verify.upload');
        });

    });

});

require __DIR__.'/auth.php';
