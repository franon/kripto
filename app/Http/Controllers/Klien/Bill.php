<?php

namespace App\Http\Controllers\Klien;

use App\Http\Controllers\Controller;
use App\Models\Klien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class Bill extends Controller
{
    public function index(){
        return view('klien.bill');
    }

    public function detail(Request $request){
        $this->validate($request,[
            'k_id'=>'required'
        ]);
        $tagihan = DB::table('tagihan_klien')->where([
            ['k_id','=',$request->k_id],
            ['tagihan_periode','=',date('ym')],
        ])->get();
        if (empty($tagihan->toArray())) return back();
        // return $tagihan;
        return view('klien.bill-detail',compact('tagihan'));
    }
}
