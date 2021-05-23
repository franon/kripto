<?php

namespace App\Http\Controllers\Employee\Drive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class SimpleDrive extends Controller
{
    public function showDirectory(){
        return Storage::allDirectories('encryptstorage');
    }

    public function showFiles(){
        $user = Auth::user();
        $files = Storage::disk('frandrive')->files();
        // dd($files);
        return view('employee.drive.drive',compact('user','files'));
    }

    public function uploadFiles($path,$content){
        return Storage::disk('frandrive')->put($path, $content);
    }

    public function downloadFiles($path){
        return Storage::disk('frandrive')->download($path);
    }

    public function removeFiles($path){
        Storage::disk('frandrive')->delete($path);
        return redirect()->back();
    }

}
