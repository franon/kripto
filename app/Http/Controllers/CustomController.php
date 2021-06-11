<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomController extends Controller
{
    public function sanitizeUser($user){
        $user = [
            'p_id'=>$user->p_id,
            'p_namapengguna'=>$user->p_namapengguna,
            'p_namalengkap'=>$user->p_namalengkap,
            'no_hp'=>$user->no_hp
        ];
        return (object)$user;
    }

    public function sanitizeKlien($klien){
        $temp = [];
        foreach ($klien as $idxk => $k) {
            $temp[$idxk] = [
                'k_id'=>$k['k_id'],
                'k_namapengguna'=>$k['k_namapengguna'],
                'k_namalengkap'=>$k['k_namalengkap'],
                'k_alamat'=>$k['k_alamat'],
                'no_hp'=>$k['no_hp'],
                'mulai_berlangganan'=>$k['mulai_berlangganan'],
                'no_kontrak'=>$k['no_kontrak'],
            ];
            $temp[$idxk] = (object)$temp[$idxk];
        }
        
        $klien = $temp;

        return $klien;
    }
}
