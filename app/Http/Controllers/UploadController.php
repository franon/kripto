<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Employee\Drive\SimpleDrive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Encryption;


class UploadController extends SimpleDrive
{
    public function upload(){
        return view('form-upload');
    }

    public function upload_process(Request $request, Encryption $encryption){
        $this->validate($request, [
            'file'=>'required',
            'keterangan'=>'required'
            ]);

        $file = $request->file;
        $encrypted = $encryption->EncryptFile_AES($this->fileHandler('open',$file->path()));
        $this->uploadFiles($file->getClientOriginalName(), $encrypted);
        return $this->downloadFiles($file->getClientOriginalName());
    }

    public function fileHandler($type,$path){
        $chunkSize = 1024*1024;
        $tempFile = '';

        switch ($type) {
            case 'open':
                $handle = fopen($path,'r');
                while(!feof($handle)){
                    $line = fread($handle, $chunkSize);
                    $tempFile .= $line;
                }
                fclose($handle);
                return $tempFile;
            default:
                return false;
        }
    }
}
