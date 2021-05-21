<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Encryption;


class UploadController extends Controller
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
            // $file = $request->file('file');
            // echo 'Filename: '.$file->getClientOriginalName().'<br>';
            // echo 'File Extension: '.$file->extension().'<br>';
            // echo 'File path: '.$file->path().'<br>';
            // echo 'File Size:'.$file->getSize().'<br>';
            // echo 'Mime Type: '.$file->getMimeType().'<br>';
            // $file = $file->storeAs('avatars',$file->getClientOriginalName());
            // dd($file);
            // $tujuanUpload = 'data_file';
            // $file->move($tujuanUpload, $file->getClientOriginalName());
        $start = microtime(true);
        // $encrypted = $encryption->cobaenkrip_256($this->fileHandler('open',$file->path()));
        // Storage::disk('frandrive')->put($file->getClientOriginalName(), $encrypted,'public');
        dd(Storage::disk('frandrive')->exists($file->getClientOriginalName()));
        // dd(Storage::getVisibility(storage_path('app/encryptstorage/'.$file->getClientOriginalName())));
        // dd(Storage::disk('frandrive')->download(storage_path('app/encryptstorage/'.$file->getClientOriginalName())));
        dd(Storage::disk('frandrive')->download($file->getClientOriginalName()));
        // Storage::download(\storage_path('app/encryptstorage/'.$file->getClientOriginalName()));
        // dd(\sprintf('%f (s)', \microtime(true)-$start));
        // return back();

    }

    public function fileHandler($type,$path=false,$content=false){
        $chunkSize = 1024*1024;
        $tempFile = '';

        switch ($type) {
            case 'open':
                // $path = "../storage/app/bahantest/".$path;
                $handle = fopen($path,'r');
                while(!feof($handle)){
                    $line = fread($handle, $chunkSize);
                    $tempFile .= $line;
                }
                fclose($handle);
                return $tempFile;
                // $hashed = hash("sha256",$tempFile);
                // return [$tempFile,$hashed];

            case 'write':
                $lenContent = strlen($content);
                if($lenContent < 1) return false;
                $filename = "../storage/app/bahantest/".$filename;
                $handle = fopen($filename,'w');
                $len = $lenContent;
                $writtenTotal = 0;
                while($writtenTotal < $lenContent){
                    $written = fwrite($handle, $content);
                    // echo $written;
                    if($written == $lenContent) return;
                    if($written < 1) return "could only write. $written/$lenContent. bytes!";

                    $writtenTotal += $written;
                    $content =  substr($content, $written);
                    $len -= $written;
                    fclose($handle);
                }

            default:
                return 'Wrong Option';
        }

    }
}
