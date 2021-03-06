<?php

use App\Http\Controllers\Employee\DigitalSignature;
use App\Http\Controllers\Employee\Drive\SimpleDrive;
use App\Http\Controllers\Employee\Drive\FileProcessing;
use App\Http\Controllers\Employee\Drive\KriptoDrive;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\internal\DaftarPaket;
use App\Http\Controllers\Employee\internal\Direktori;
use App\Http\Controllers\Employee\MultiSec;
use App\Http\Controllers\Employee\tagihan\DaftarKlien;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Encryption;
use App\Http\Controllers\Klien\Bill;
use Illuminate\Support\Facades\Auth;

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
    if (Auth::check()) {
        echo 'wow';
    }
    return redirect()->route('login'); // return view('welcome'); 
});

route::get('testing',[Encryption::class,'testing']);
route::get('coba256',[Encryption::class,'cobaenkrip_256']);
route::get('cobarsa',[Encryption::class,'cobaenkrip_RSA']);

Route::get('ver/{penentu}/{filename}', [SimpleDrive::class, 'downloadFiles'])->name('public.download');

Route::get('klien/bill',[Bill::class,'index'])->name('bill');
Route::post('klien/bill/detail',[Bill::class,'detail'])->name('bill.detail');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('employee.dashboard');
    })->name('dashboard-default');

    Route::prefix('employee')->name('employee.')->group(function(){
        Route::get('dashboard',[EmployeeController::class,'index'])->name('dashboard');

        Route::get('drive', [SimpleDrive::class, 'showDirectory'])->name('drive');
        Route::get('drive/personal', [SimpleDrive::class, 'showFilesPersonal'])->name('drive.personal');
        Route::get('drive/{directory}', [SimpleDrive::class, 'showFiles'])->name('drive.directory');
        Route::get('drive/download/{filename}', [SimpleDrive::class, 'downloadFiles'])->name('drive.file.download');
        Route::get('drive/remove/{filename}', [SimpleDrive::class, 'removeFiles'])->name('drive.file.remove');

        Route::get('kriptodrive', [KriptoDrive::class, 'index'])->name('kriptodrive');

        Route::prefix('file')->name('file.')->group(function(){
            Route::get('encrypt', [FileProcessing::class, 'show_FileEncryption'])->name('encrypt');
            Route::get('encrypt/multi', [FileProcessing::class, 'show_FileEncryptionMulti'])->name('encrypt.multi');
            Route::post('encrypt/upload', [FileProcessing::class, 'process_FileEncryption'])->name('encrypt.upload');
            Route::get('decrypt', [FileProcessing::class, 'show_FileDecryption'])->name('decrypt');
            Route::post('decrypt/upload', [FileProcessing::class, 'process_FileDecryption'])->name('decrypt.upload');
            Route::post('decrypt/download', [FileProcessing::class, 'process_DownloadFileDecryption'])->name('decrypt.download');

            Route::get('sign', [DigitalSignature::class, 'show_FormSign'])->name('sign');
            Route::post('sign/process', [DigitalSignature::class, 'createSign'])->name('sign.upload');
            Route::get('verify', [DigitalSignature::class, 'show_FormVerify'])->name('verify');
            Route::post('verify/process', [DigitalSignature::class, 'verifySign'])->name('verify.upload');

            Route::get('multisec',[MultiSec::class, 'show_FormMultisec'])->name('multisec');
            Route::post('multisec/process',[MultiSec::class, 'process_Multisec'])->name('multisec.upload');
        });

        Route::prefix('daftar')->name('daftar.')->group(function(){
            Route::get('klien', [DaftarKlien::class, 'showDaftarKlien'])->name('klien');
            Route::get('klien/tambah', [DaftarKlien::class, 'showCreateDataKlien'])->name('klien.tambah');
            Route::post('klien/tambah/proses', [DaftarKlien::class, 'createDataKlien'])->name('klien.tambah.proses');
            Route::post('klien/tambah/paket/proses', [DaftarKlien::class, 'addPaketKlien'])->name('klien.tambah.paket.proses');
            
            Route::get('tagihan/klien', [DaftarKlien::class, 'showDaftarTagihanSemuaKlien'])->name('tagihan.klien');
            Route::get('tagihan/klien/{klien_id}', [DaftarKlien::class, 'showDaftarSemuaTagihanKlienTertentu'])->name('tagihan.klien.tertentu');
            Route::get('tagihan/klien/{klien_id}/cetak', [DaftarKlien::class, 'cetakPDFKlienTagihan'])->name('tagihan.klien.cetak');
            
            Route::get('klien/{k_id}', [DaftarKlien::class, 'showDetailKlien'])->name('klien.detail');
        });

        Route::prefix('internal')->name('internal.')->group(function(){
            Route::get('paket/internet',[DaftarPaket::class, 'showPaketInternet'])->name('paket_internet');
            Route::get('paket/internet/tambah',[DaftarPaket::class, 'showCreatePaketInternet'])->name('paket_internet.tambah');
            Route::post('paket/internet/tambah/proses',[DaftarPaket::class, 'createPaketInternet'])->name('paket_internet.tambah.proses');

            Route::get('direktori',[Direktori::class, 'showDirektori'])->name('direktori');
            Route::get('direktori/tambah',[Direktori::class, 'showCreateDirektori'])->name('direktori.tambah');
            Route::post('direktori/tambah/proses',[Direktori::class, 'createDirektori'])->name('direktori.tambah.proses');
        });

    });

});

require __DIR__.'/auth.php';
