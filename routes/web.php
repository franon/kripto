<?php

use App\Http\Controllers\enkripsirsa;
use App\Http\Controllers\KriptoTemp1;
use App\Http\Controllers\sha256;
use App\Http\Controllers\Encryption;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\returnArgument;

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

// Route::get('coba', [KriptoTemp1::class,'openFile']);
// Route::get('cobasplit', [KriptoTemp1::class,'openFileSplit']);
// Route::get('sha', [sha256::class,'cetak']);
// Route::get('hashfile', [sha256::class,'hashfile']);
// Route::get('test', [sha256::class,'test']);
// Route::get('test', [enkripsirsa::class,'encrypt']);
// Route::get('testFile', [enkripsirsa::class,'hashfile']);

Route::get('coba', [KriptoTemp1::class,'testing']);
Route::get('enkrip', [Encryption::class, 'EncryptFile_AES']);
Route::get('cobax', [Encryption::class, 'cobaenkrip']);
Route::get('coba128', [Encryption::class, 'cobaenkrip']);
Route::get('coba256', [Encryption::class, 'cobaenkrip_256']);

Route::get('/upload', [UploadController::class, 'upload']);
Route::post('/upload/process', [UploadController::class, 'upload_process']);


