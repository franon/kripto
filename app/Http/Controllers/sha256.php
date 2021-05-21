<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sha256 extends Controller
{
    //
    // define("CHUNK_SIZE", 64);
    // define("TOTAL_LEN_LEN", 8);
    

    //! Initialize Round Constant (k)
    //? first 32-bit of fractional parts of cube roots of the first 64 primes (2-311)
    private $k = [
    0x428a2f98, 0x71374491, 0xb5c0fbcf, 0xe9b5dba5, 0x3956c25b, 0x59f111f1, 0x923f82a4, 0xab1c5ed5, 
    0xd807aa98, 0x12835b01, 0x243185be, 0x550c7dc3, 0x72be5d74, 0x80deb1fe, 0x9bdc06a7, 0xc19bf174, 
    0xe49b69c1, 0xefbe4786, 0x0fc19dc6, 0x240ca1cc, 0x2de92c6f, 0x4a7484aa, 0x5cb0a9dc, 0x76f988da, 
    0x983e5152, 0xa831c66d, 0xb00327c8, 0xbf597fc7, 0xc6e00bf3, 0xd5a79147, 0x06ca6351, 0x14292967, 
    0x27b70a85, 0x2e1b2138, 0x4d2c6dfc, 0x53380d13, 0x650a7354, 0x766a0abb, 0x81c2c92e, 0x92722c85, 
    0xa2bfe8a1, 0xa81a664b, 0xc24b8b70, 0xc76c51a3, 0xd192e819, 0xd6990624, 0xf40e3585, 0x106aa070, 
    0x19a4c116, 0x1e376c08, 0x2748774c, 0x34b0bcb5, 0x391c0cb3, 0x4ed8aa4a, 0x5b9cca4f, 0x682e6ff3, 
    0x748f82ee, 0x78a5636f, 0x84c87814, 0x8cc70208, 0x90befffa, 0xa4506ceb, 0xbef9a3f7, 0xc67178f2
    ];

    //! initialized hash values (h)
    //? constants represent the first 32-bit of fractional parts of the square roots of the first 8 primes (2-19)
    private $h = [0x6a09e667, 0xbb67ae85, 0x3c6ef372, 0xa54ff53a, 0x510e527f, 0x9b05688c, 0x1f83d9ab, 0x5be0cd19];

    // public function cetak(){
    //     $binarynya = decbin($this->h[0]);
    //     $desimalnya = bindec($binarynya);
    //     $hexnya = dechex(bindec($binarynya));
    //     var_dump($binarynya,$desimalnya,$hexnya);

    //     $binaryasli = 'A';
    //     dd(bin2hex($binaryasli));
        
    // }

    public function test(){
        // $c = bcpow(5,65537);
        // $modulus = '7352663297745655707564770898973026111123571131674342064274310466656682149875713713190619593857622635229550350695840423707750477946865389780644345442690161';
        // $c_mod = bcmod($c,$modulus);
        // $d = '6819755922304426102747146323998250426734036016007571769550673822980297203785407650915979348036083257381776925124546653452752122738795086061047165138871297';
        // $d_awal = bcpow($c_mod,$d);
        // $m = bcpowmod($c_mod,$d,$modulus);
        // $m = bcmod($d_awal,$modulus);
        // echo $c_mod.'<br>';
        // echo $m;
        $pub = serialize(['keypub','modulus',1024]);
        $priv = serialize(['keypriv','modulus',1024]);
        $key = [$pub,$priv];
        // dd($key[0]);

        list($p, $r, $keysize) = unserialize($key[0]);
        dd($p,$r,$keysize);
    }

    public function hashfile(){
        //* Work untuk read data in bytes until <= 50Mb

        // $starttime = microtime(true);
        // $chunk_size = 1024*1024; //! bytes
        // $iterations = 0;
        // $isifile = '';
        // $file = fopen(base_path('storage\app\bahantest\50mb'),'r');
        // while(!feof($file)){
        //     // $line = fgets($file);
        //     $iterations++;
        //     $line = fread($file, $chunk_size);
        //     $isifile .= $line;
        // }
        // fclose($file);

        // var_dump($iterations,microtime(true)-$starttime);

        // $starttime = microtime(true);
        // $hashed = hash("sha256",$isifile);
                
        // var_dump($hashed, microtime(true)-$starttime);

        $a = 0xD; $b = 0x5;
        $c = base_convert($a ^ $b,16,2);

        var_dump($c);
    }
}
