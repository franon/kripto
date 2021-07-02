<?php

namespace App\Http\Controllers\Employee\Drive;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employee\Drive\SimpleDrive;
use App\Http\Controllers\Encryption;
use App\Models\Direktori;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileProcessing extends SimpleDrive
{
    
    public function show_FileEncryption(){
        // $clientIP = \Request::getClientIp(true); dd($clientIP);
        // dd(storage_path('app/encryptstorage'),Storage::disk('frandrive'));
        $user = $this->sanitizeUser(Auth::user()); 
        return view('employee.file_processing.form-file-encryption',compact('user'));
    }

    public function process_FileEncryption(Request $request){
        $user = $this->sanitizeUser(Auth::user()); 
        $encryption = new Encryption();
        $this->validate($request, [
            'file'=>'required|file|max:10240',
            'kunci'=>'required|size:32'
            ]);
        $file = $request->file; $filename = $file->getClientOriginalName().'.gmdp';
        $directory = $request->direktori == null ? Direktori::firstWhere('dir_jalur', 'encrypted/') : Direktori::firstWhere('dir_jalur', $request->direktori);
        $path = $directory->dir_jalur.$filename;
        $encrypted = $encryption->encrypt_AES($this->fileHandler('open',$file->path()), $request->kunci);

        $this->uploadFiles($path, $encrypted);
        $directory->file()->create([
            'file_id'=>'file-'.sha1(md5(microtime(true))),
            'file_nama'=>$filename,
            'file_alias'=>$filename,
            'file_tipe'=>$file->getClientOriginalExtension(),
            'file_jalur'=>$path,
            'file_jalurutuh'=>$path,
            'file_ukuran'=>$file->getSize(),
            'p_id'=>$user->p_id,
            'pembuat'=>$user->p_namapengguna,
            'tanggal_buat'=>date('Y-m-d'),
            'dir_nama'=>$directory->dir_nama
        ]);

        return redirect()->route('employee.drive');
    }

    public function show_FileDecryption(){
        $user = $this->sanitizeUser(Auth::user()); 
        return view('employee.file_processing.form-file-decryption',compact('user'));
    }

    public function process_DownloadFileDecryption(Request $request){
        $this->validate($request, [
            'filename'=>'required',
            'kunci'=>'required|size:32'
        ]);
        $decryption = new Encryption();
        $file = Storage::disk('frandrive')->get($request->filename);
        $message = $decryption->Decrypt_AES($file,$request->kunci);
        $filename = substr($request->filename,0,-5);
        
        return response()->make($message, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($message),
            'Content-Disposition' => 'attachment; filename="' . pathinfo($filename, PATHINFO_BASENAME) . '"'
        ]);
    }
    
    public function process_FileDecryption(Request $request, Encryption $decryption){
        $this->validate($request, [
            'file'=>'required|file|max:10240',
            'kunci'=>'required|size:32'
            ]);
        $file = $request->file;
        $message = $decryption->decrypt_AES($this->fileHandler('open',$file->path()), $request->kunci);
        if (!$message || (substr($file->getClientOriginalName(),-5) !== '.gmdp')) return redirect(url()->previous())->with('error','Harap cek file');
        $filename = substr($file->getClientOriginalName(),0,-5);
        return response()->make($message, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($message),
            'Content-Disposition' => 'attachment; filename="' . pathinfo($filename, PATHINFO_BASENAME) . '"'
        ]);

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
