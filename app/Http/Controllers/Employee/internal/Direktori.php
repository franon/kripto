<?php

namespace App\Http\Controllers\employee\internal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomController;
use App\Models\Direktori as ModelsDirektori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Direktori extends CustomController
{
    public function showDirektori(){
        $user = $this->sanitizeUser(Auth::user()); 
        $direktori = ModelsDirektori::all();
        return view('employee.internal.direktori.daftar-direktori',compact('user','direktori'));
    }

    public function showCreateDirektori(){
        $user = $this->sanitizeUser(Auth::user()); 
        return view('employee.internal.direktori.direktori-tambah', compact('user'));
    }

    public function createDirektori(Request $request){
        $user = $this->sanitizeUser(Auth::user()); 
        $this->validate($request,[
            // 'dir_id'=>'required',
            'dir_nama'=>'required',
            // 'dir_jalur'=>'required'
        ]);

        $direktori = ModelsDirektori::create([
            'dir_id'=>'dir-'.sha1(md5(microtime(true))),
            'p_id'=>$user->p_id,
            'dir_nama'=>$request->dir_nama,
            'dir_jalur'=>$request->dir_parent.trim($request->dir_nama).'/',
            'dir_didalam'=>$request->dir_parent,
            'pembuat'=>$user->p_namapengguna,
            'tanggal_buat'=>date('Y-m-d')
        ]);

        Storage::disk('dropbox')->makeDirectory($request->dir_jalur);

        return redirect()->route('employee.internal.direktori');
    }
}
