<?php

namespace App\Http\Controllers;

use App\Mylib\RsaEncryption;
use Illuminate\Http\Request;

class enkripsirsa extends Controller
{
    public function encrypt(){
        $time = microtime(true);
        $RSA = new RsaEncryption();
        $keys = $RSA->keyGen(1024);
        // $message = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec. Vitae tortor condimentum lacinia quis vel eros donec ac odio. Habitant morbi tristique senectus et.';
        $message = '93b79b12050ad003b063da7035293897782f8ed83ae3bc3201e02c9c1370da48';
        // $message = 'Mueheheheheh ';
        
        $encrypt = $RSA->encrypt($message, $keys['public']);
        $decrypt = $RSA->decrypt($encrypt,$keys['private']);
        // var_dump($decrypt);die;
        echo microtime(true)-$time;
        // dd($message,$encrypt, $decrypt);

        return $encrypt;
    }

    // public function decrypt(){
    //     $RSA = new RsaEncryption();
    
    // }

    public function hashfile(){
        //* Work untuk read data in bytes until <= 50Mb
        $starttime = microtime(true);

        $chunk_size = 1024*1024; //! bytes
        $iterations = 0;
        $isifile = '';
        $file = fopen(base_path('storage\app\bahantest\word.docx'),'r');
        while(!feof($file)){
            // $line = fgets($file);
            $iterations++;
            $line = fread($file, $chunk_size);
            $isifile .= $line;
        }
        fclose($file);
        // var_dump($isifile);
        // var_dump($iterations,microtime(true)-$starttime);
        
        // $starttime = microtime(true);
        // $hashed = hash("sha256",$isifile);
        
        // $this->encrypt($isifile);
        // var_dump($hashed, microtime(true)-$starttime);
        echo (microtime(true)-$starttime);

        }
}
