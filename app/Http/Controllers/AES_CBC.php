<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AES_CBC extends KriptoTemp1
{
    public function encrypt($message, $key, $iv){
        $message = pad($message);
        $n = strlen($message)/16;
        $cipher = "";

        for ($i=0; $i < $n; $i++) { 
            $index = 16*$i;
            $temp = $this->strxor(substr($message,$index,$index+16),$iv);
            $iv = AES::encrypt($temp, $key);
            $cipher .= $iv;
        }

        return $cipher;
    }

    public function decrypt($cipher, $key, $iv){
        $cipher = unpad($cipher);
        $n = strlen($cipher)/16;
        $message = "";

        for ($i=0; $i < $n; $i++) { 
            $index = 16*1;
            $cipherBlock = substr($cipher,$index,$index+16);
            $temp = AES::decrypt($cipherBlock, $key);
            $message .= $this->strxor($temp, $iv);
            $iv = $cipherBlock;
        }
    }

    public function strxor ($str1, $str2){
        $result = "";
        
    }
}
