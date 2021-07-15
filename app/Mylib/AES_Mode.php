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
            // $starttime = microtime(true);
            $temp = AES_Encryption::encrypt($blockMessage,$word);
            // echo 'Blocking time: '. sprintf('%f (s)', \microtime(true)-$starttime).'<br>';
            $cipher .= $temp;
        }
        return $cipher;
    }

    //! Menangani pembagian block
    public function Pure_Decrypt($cipher,$key){
        $n = strlen($cipher)/16;if(!is_int($n)) return false;
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
        // dd(str_split($message,16));
        
        for ($i=0; $i < $n; $i++) {
            $index = 16*$i;
            // $arrx[$i] = substr($message,$index,16);
            // dd(array_map('dechex',str_split(substr($message,$index,16)),1),$iv);
            $temp = $this->strxor(substr($message,$index,16),$iv);
            // $starttime = \microtime(true);
            $iv = AES_Encryption::encrwypt($temp, $word);
            // echo 'Enc /16b: '. sprintf('%f (s)', \microtime(true)-$starttime).'<br>';
            $cipher .= $iv;
        }
        // dd($arrx);
        // die;
        return $cipher;
    }
    
    public function CBC_Decrypt($cipher, $key, $iv){
        // $cipher = base64_decode($cipher);
        $n = strlen($cipher)/16;if(!is_int($n)) return false;
        $message = "";
        // dd(str_split($cipher,16));
        $word = $this->keyExpansion($this->keyDec($key));
        for ($i=0; $i < $n; $i++) {
            $index = 16*$i;
            $cipherBlock = substr($cipher,$index,16);
            $temp = AES_Encryption::decrypt($cipherBlock, $word);
            $message .= $this->strxor($temp, $iv);
            $iv = $cipherBlock;
        }
        $message = $this->unpad($message);
        return $message;
    }

    public function strxor ($str1, $str2){
        // $starttime = microtime(true);
        $res = '';
        for ($i=0; $i < 16; $i++) {
            // $hex1[$i] = dechex(ord($str1[$i]));
            // $hex2[$i] = dechex(ord($str2[$i]));
            // $hex3[$i] = dechex(ord($str1[$i]) ^ ord($str2[$i]));
            $res[$i] = chr(ord($str1[$i]) ^ ord($str2[$i]));
        }
        // dd($hex1,$hex2,$hex3);
        // echo 'xoring time: '.\sprintf('%f (s)', \microtime(true)-$starttime).'<br>';
        return $res;
    }
}