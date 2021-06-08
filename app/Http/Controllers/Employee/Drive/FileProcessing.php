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
        // dd(storage_path('app/encryptstorage'),Storage::disk('frandrive'));
        $user = Auth::user();
        return view('employee.file_processing.form-file-encryption',compact('user'));
    }

    public function process_FileEncryption(Request $request){
        $encryption = new Encryption();
        $this->validate($request, [
            'file'=>'required|file',
            'key'=>'required|size:32'
            ]);
        $file = $request->file; $filename = $file->getClientOriginalName();
        $path = 'encrypted/'.$filename;

        $encrypted = $encryption->encrypt_AES($this->fileHandler('open',$file->path()));

        $this->uploadFiles($path, $encrypted);
        $directory = Direktori::find('dir-01');
        $directory->file()->create([
            'file_id'=>'file-'.sha1(md5(microtime(true))),
            'file_nama'=>$filename,
            'file_alias'=>$filename,
            'file_tipe'=>$file->getClientOriginalExtension(),
            'file_jalur'=>'encrypted/',
            'file_jalurutuh'=>$path,
            'file_ukuran'=>$file->getSize(),
            'p_id'=>Auth::user()->p_id,
            'pembuat'=>Auth::user()->p_namapengguna,
            'tanggal_buat'=>date('Y-m-d'),
            'dir_nama'=>$directory->dir_nama
        ]);

        return redirect()->route('employee.drive');
    }

    public function show_FileDecryption(){
        $user = Auth::user();
        return view('employee.file_processing.form-file-decryption',compact('user'));
    }

    public function process_DownloadFileDecryption($filename){
        // dd($file);
        $decryption = new Encryption();
        $file = Storage::disk('frandrive')->get($filename);
        $message = $decryption->Decrypt_AES($file);
        
        return response()->make($message, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($message),
            'Content-Disposition' => 'attachment; filename="' . pathinfo($filename, PATHINFO_BASENAME) . '"'
        ]);
    }
    
    public function process_FileDecryption(Request $request, Encryption $decryption){
        $this->validate($request, [
            'file'=>'required',
            'keterangan'=>'required'
            ]);
        $file = $request->file;
        $message = $decryption->decrypt_AES($this->fileHandler('open',$file->path()));
        // dd($message);
        return response()->make($message, 200, [
            'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($message),
            'Content-Disposition' => 'attachment; filename="' . pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME) . '"'
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
