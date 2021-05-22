<?php

namespace App\Http\Controllers\Drive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SimpleDrive extends Controller
{
    public function showDirectory(){
        return Storage::allDirectories('encryptstorage');
    }

    public function showFiles(){
        return Storage::disk('frandrive')->files();
    }

    public function uploadFiles($path,$content){
        return Storage::disk('frandrive')->put($path, $content);
    }

    public function downloadFiles($path){
        return Storage::disk('frandrive')->download($path);
    }

}
