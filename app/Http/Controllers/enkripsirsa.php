<?php

namespace App\Http\Controllers;

use App\Mylib\RsaEncryption;
use Illuminate\Http\Request;

class enkripsirsa extends Controller
{
    public function encrypt(){
        $starttime = microtime(true);
        $RSA = new RsaEncryption();
        $keys = $RSA->newKeyGen(1024);
        $message = hash('sha256','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec. Vitae tortor condimentum lacinia quis vel eros donec ac odio. Habitant morbi tristique senectus et.');
        // $message = '93b79b12050ad003b063da7035293897782f8ed83ae3bc3201e02c9c1370da48';
        // $message = '93b79b12050ad003b063da7035293897782f8ed83ae3bc3201e02c9c1370da4893b79b12050ad003b063da7035293897782f8ed83ae3bc3201e02c9c1370da4893b79b12050ad003b063da7035293897782f8ed83ae3bc3201e02c9c1370da48';
        // $message = 'Mueheheheheh ';
        
        // echo json_encode($keys);
        $encrypt = $RSA->encrypt($message, $keys['public']);
        $decrypt = $RSA->decrypt($encrypt,$keys['private']);
        echo 'Time elapsed: '. sprintf('%f (s)', \microtime(true)-$starttime).'<br>';
        // var_dump($decrypt);die;
        // echo json_encode([$message,$encrypt,$decrypt]);
        // die;
        dd($message,$encrypt, $decrypt);

        // return $encrypt;
    }
}
