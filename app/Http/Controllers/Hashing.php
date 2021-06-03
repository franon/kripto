<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mylib\Hash;

class Hashing extends Controller
{
    public function __construct()
    {
    }

    public function hash($type, $message){
        $hashFunc = new Hash();
        switch ($type) {
            case 'sha256':
                return $hashFunc->sha256($message);
            default:
                break;
        }
    }
}
