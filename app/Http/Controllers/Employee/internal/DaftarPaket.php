<?php

namespace App\Http\Controllers\employee\internal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomController;
use App\Models\Klien;
use App\Models\Paket_Internet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarPaket extends CustomController
{
    public function showPaketInternet(){
        $user = $this->sanitizeUser(Auth::user()); 
        $paket = Paket_Internet::all();
        return view('employee.internal.daftar-paket',compact('user','paket'));
    }

    public function showCreatePaketInternet(){
        $user = $this->sanitizeUser(Auth::user()); 
        return view('employee.internal.paket-tambah', compact('user'));
    }

    public function createPaketInternet(Request $request){
        $this->validate($request,[
            'pinet_id'=>'required',
            'pinet_tipe'=>'required',
            'pinet_harga'=>'required'
        ]);

        $paket_internet = Paket_Internet::create([
            'pinet_id'=>$request->pinet_id,
            'pinet_tipe'=>$request->pinet_tipe,
            'pinet_harga'=>$request->pinet_harga
        ]);

        return redirect()->route('employee.internal.paket_internet');
    }
}
