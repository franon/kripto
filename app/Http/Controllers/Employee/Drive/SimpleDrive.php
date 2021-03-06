<?php

namespace App\Http\Controllers\Employee\Drive;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\Encryption;
use App\Models\Direktori;
use App\Models\FileProcessing;
use Illuminate\Http\Request;
use finfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Inline\Element\Strong;

class SimpleDrive extends CustomController
{
    public function showDirectory(){
        $user = $this->sanitizeUser(Auth::user());
        // $directory =  Storage::disk('frandrive')->directories();
        $directory = Direktori::whereNull('dir_didalam')->get();
        return view('employee.drive.drive', compact('user','directory'));
    }

    public function showFilesPersonal(){
        $user = $this->sanitizeUser(Auth::user());
        // $directory =  Storage::disk('frandrive')->directories();
        $files = FileProcessing::where('pembuat',$user->p_namapengguna)->get();
        return view('employee.drive.drive-personal', compact('user','files'));
    }

    public function showFiles($currentDirectory){
        $currentDirectory = base64_decode($currentDirectory);
        // return Storage::makeDirectory($currentDirectory.'testing');
        $user = $this->sanitizeUser(Auth::user());
        //! 1. Show Directory
        // $directory = Storage::disk('frandrive')->directories($currentDirectory);dd($directory);
        $directory = Direktori::where('dir_didalam','=',$currentDirectory)->get();
        
        //! 2. Show Files
        $currentDirectory = Direktori::where('dir_jalur',$currentDirectory)->first();
        $files = Direktori::find($currentDirectory->dir_id)->file()->get();
        if (isset($files)){
            if (empty($directory)) return view('employee.drive.drive',compact('user','files'));
            return view('employee.drive.drive',compact('user','files','directory'));
        }elseif(!isset($files))return view('employee.drive.drive',compact('user','directory'));
        return redirect()->route('employee.drive');
        // return Storage::download('encryptstorage/signed/19e9cb6869cc863877f3fa5221a7f53ff1940e0557dc4c60374deedb67629cba.pdf');
    }

    public function uploadFiles($path,$content){
        Storage::disk('dropbox')->put($path,$content);
        // Storage::disk('frandrive')->put($path, $content);
    }

    public function downloadFiles($path){
        return Storage::disk('dropbox')->download(base64_decode($path));
        // return Storage::disk('frandrive')->download(base64_decode($path));
        abort(404);
        // return $this->process_DownloadFileDecryption(base64_decode($path));
    }

    public function streamFiles($path){
        return response()->file(base64_decode($path));
    }

    public function removeFiles($path){
        $path = \base64_decode($path);
        Storage::disk('dropbox')->delete($path);
        // Storage::disk('frandrive')->delete($path);
        $file = FileProcessing::where('file_jalurutuh',$path)->delete();
        return redirect()->back();
    }
}
