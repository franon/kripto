<?php

namespace App\Http\Controllers\Employee\Drive;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Encryption;
use Illuminate\Http\Request;
use finfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Inline\Element\Strong;

class SimpleDrive extends Controller
{
    public function showDirectory(){
        $user = Auth::user();
        $directory =  Storage::disk('frandrive')->directories();
        return view('employee.drive.drive', compact('user','directory'));
    }

    public function showFiles($currentDirectory){
        $currentDirectory = base64_decode($currentDirectory);
        $user = Auth::user();
        //! 1. Show Directory
        $directory = Storage::disk('frandrive')->directories($currentDirectory); 
        //! 2. Show Files And Directory
        if(Storage::disk('frandrive')->files($currentDirectory) != null){
            foreach (Storage::disk('frandrive')->files($currentDirectory) as $i => $file) {
                // $filename = explode('/',$file); $filename = end($filename);
                $files[$i] = [
                    'filename'=> pathinfo($file,PATHINFO_BASENAME),
                    'size'=> round((Storage::disk('frandrive')->size($file))/1000000,2),
                    'path'=>$file
                ];
            };
        }
        if (isset($files)){
            if (empty($directory)) return view('employee.drive.drive',compact('user','files'));
            return view('employee.drive.drive',compact('user','files','directory'));
        }elseif(!isset($files))return view('employee.drive.drive',compact('user','directory'));
        return redirect()->route('employee.drive');
        // return Storage::download('encryptstorage/signed/19e9cb6869cc863877f3fa5221a7f53ff1940e0557dc4c60374deedb67629cba.pdf');
    }

    public function uploadFiles($filename,$content,$directory = 'encrypted'){
        // return Storage::disk('frandrive')->putFileAs($directory, $content, $filename);
        $filename = $directory.'/'.$filename;
        return Storage::disk('frandrive')->put($filename, $content);
    }

    public function downloadFiles($penentu,$path){
        switch ($penentu) {
            case 'encrypted':
                return $this->process_DownloadFileDecryption(base64_decode($path));
                break;
            case 'signed':
                return Storage::disk('frandrive')->download(base64_decode($path));
            default:
                abort(404);
        }
    }

    public function removeFiles($path){
        Storage::disk('frandrive')->delete($path);
        return redirect()->back();
    }

    public function process_DownloadFileDecryption($filename){
        $decryption = new Encryption();
        $file = Storage::disk('frandrive')->get($filename);
        $message = $decryption->Decrypt_AES($file);
        
        return response()->make($message, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($message),
            'Content-Disposition' => 'attachment; filename="' . pathinfo($filename, PATHINFO_BASENAME) . '"'
        ]);
    }

}
