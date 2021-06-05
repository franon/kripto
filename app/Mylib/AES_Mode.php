<?php

namespace App\Mylib;
class AES_Mode extends AES_Encryption
{
    //! Menangani pembagian block
    public function Pure_Encrypt($message,$key){
        $message = $this->pad($message);
        $n = strlen($message)/16;
        $cipher = "";
        $word = $this->keyExpansion($this->keyDec($key));

        for ($i=0; $i < $n; $i++) { 
            $index = 16*$i;
            $blockMessage = substr($message, $index,16);
            $starttime = microtime(true);
            $temp = AES_Encryption::encrypt($blockMessage,$word);
            echo 'Blocking time: '. sprintf('%f (s)', \microtime(true)-$starttime).'<br>';
            $cipher .= $temp;
        }
        return base64_encode($cipher);
    }

    //! Menangani pembagian block
    public function Pure_Decrypt($cipher,$key){
        $cipher = base64_decode($cipher);
        $n = strlen($cipher)/16;
        $message = "";
        $word = $this->keyExpansion($this->keyDec($key));

        for ($i=0; $i < $n; $i++) {
            $index = 16*$i;
            $blockCipher = substr($cipher, $index,16);
            $temp = AES_Encryption::decrypt($blockCipher,$word);
            $message .= $temp;
        }
        $message = $this->unpad($message);
        return $message;
    }

    public function CBC_Encrypt($message,$key, $iv){
        $message = $this->pad($message);
        $n = strlen($message)/16;
        $cipher = "";
        $word = $this->keyExpansion($this->keyDec($key));
        
        for ($i=0; $i < $n; $i++) {
            $index = 16*$i;
            $temp = $this->strxor(substr($message,$index,$index+16),$iv);
            // $starttime = \microtime(true);
            $iv = AES_Encryption::encrypt($temp, $word);
            // echo 'Blocking time: '. sprintf('%f (s)', \microtime(true)-$starttime).'<br>';
            $cipher .= $iv;
        }
        // dd($cipher);
        // die;
        return base64_encode($cipher);
    }
    
    public function CBC_Decrypt($cipher, $key, $iv){
        $cipher = base64_decode($cipher);
        $n = strlen($cipher)/16;
        $message = "";
        $word = $this->keyExpansion($this->keyDec($key));
        for ($i=0; $i < $n; $i++) {
            $index = 16*$i;
            $cipherBlock = substr($cipher,$index,$index+16);
            $temp = AES_Encryption::decrypt($cipherBlock, $word);
            $message .= $this->strxor($temp, $iv);
            $iv = $cipherBlock;
        }
        $message = $this->unpad($message);
        return $message;
    }

    public function strxor ($str1, $str2){
        $starttime = microtime(true);
        $res = '';
        for ($i=0; $i < 16; $i++) { 
            $res[$i] = chr(ord($str1[$i]) ^ ord($str2[$i]));
        }
        // echo 'xoring time: '.\sprintf('%f (s)', \microtime(true)-$starttime).'<br>';
        return $res;
    }
}