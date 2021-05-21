<?php

namespace App\Http\Controllers;
use App\Mylib\AES_Mode;

class KriptoTemp1 extends Controller
{
    public function testing(){
        $start_time = microtime(true);
        $AES = new AES_Mode();
        // $message = 'Two One Nine TwoTwo One Nine Two';
        $password = 'Thats my Kung Fu';
        $message = 'pesanrahasia1234';
        // $password = 'passwordpasswd99';

        //! CBC-AES ENCRYPTING
        $cipher = $AES->CBC_Encrypt($message,$password,'opqrstuv12345678');
        $message = $AES->CBC_Decrypt($cipher,$password,'opqrstuv12345678');
        echo $message.'<br>';
        echo microtime(true)-$start_time;
        
        //! PURE-AES ENCRYPTING
        // $start_time = microtime(true);
        // $cipher = $AES->Pure_Encrypt($message,$password);
        // $message = $AES->Pure_Decrypt($cipher,$password);
        // echo microtime(true)-$start_time;
        
    }

}
