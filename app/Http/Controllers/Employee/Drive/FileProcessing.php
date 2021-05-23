<?php

namespace App\Http\Controllers\Employee\Drive;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employee\Drive\SimpleDrive;
use App\Http\Controllers\Encryption;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileProcessing extends SimpleDrive
{
    
    public function show_FileEncryption()
    {
        $user = Auth::user();
        return view('employee.file_processing.form-file-encryption',compact('user'));
    }

    public function process_FileEncryption(Request $request, Encryption $encryption){
        $this->validate($request, [
            'file'=>'required',
            'keterangan'=>'required'
            ]);

        $file = $request->file;
        $encrypted = $encryption->EncryptFile_AES($this->fileHandler('open',$file->path()));
        $this->uploadFiles($file->getClientOriginalName(), $encrypted);
        return redirect()->route('employee.drive');
    }

    public function show_FileDecryption()
    {
        $user = Auth::user();
        return view('employee.file_processing.form-file-decryption',compact('user'));
    }

    public function process_DownloadFileDecryption($filename, Encryption $decryption){
        // dd($file);
        $file = Storage::disk('frandrive')->get($filename);
        $message = $decryption->DecryptFile_AES($file);
        
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
        $message = $decryption->DecryptFile_AES($this->fileHandler('open',$file->path()));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
