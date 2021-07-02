<?php

namespace App\Mylib;

class Hash
{    
    public function sha256($message = false){
        //! Initialize Round Constant (k)
        //? first 32-bit of fractional parts of cube roots of the first 64 primes (2-311)
        $k = [
            0x428a2f98, 0x71374491, 0xb5c0fbcf, 0xe9b5dba5, 0x3956c25b, 0x59f111f1, 0x923f82a4, 0xab1c5ed5, 
            0xd807aa98, 0x12835b01, 0x243185be, 0x550c7dc3, 0x72be5d74, 0x80deb1fe, 0x9bdc06a7, 0xc19bf174, 
            0xe49b69c1, 0xefbe4786, 0x0fc19dc6, 0x240ca1cc, 0x2de92c6f, 0x4a7484aa, 0x5cb0a9dc, 0x76f988da, 
            0x983e5152, 0xa831c66d, 0xb00327c8, 0xbf597fc7, 0xc6e00bf3, 0xd5a79147, 0x06ca6351, 0x14292967, 
            0x27b70a85, 0x2e1b2138, 0x4d2c6dfc, 0x53380d13, 0x650a7354, 0x766a0abb, 0x81c2c92e, 0x92722c85, 
            0xa2bfe8a1, 0xa81a664b, 0xc24b8b70, 0xc76c51a3, 0xd192e819, 0xd6990624, 0xf40e3585, 0x106aa070, 
            0x19a4c116, 0x1e376c08, 0x2748774c, 0x34b0bcb5, 0x391c0cb3, 0x4ed8aa4a, 0x5b9cca4f, 0x682e6ff3, 
            0x748f82ee, 0x78a5636f, 0x84c87814, 0x8cc70208, 0x90befffa, 0xa4506ceb, 0xbef9a3f7, 0xc67178f2
        ];
                
        //! initialized hash values (hash)
        //? constants represent the first 32-bit of fractional parts of the square roots of the first 8 primes (2-19)
        $hash = [0x6a09e667, 0xbb67ae85, 0x3c6ef372, 0xa54ff53a, 0x510e527f, 0x9b05688c, 0x1f83d9ab, 0x5be0cd19];
        
        //!Preprocessing
        // $message = 'abcdbcdecdefdefgefghfghighijhijkijkljklmklmnlmnomnopnopq';
        $length = strlen($message); //* 3
        $message .= str_repeat(chr(0), 64 - (($length+8) & 0x3F)); //* 0...n | n = 64-(3+8 & 63) = 54. sediakan nilai sbnyk len_message+8bit;
        $message[$length] = chr(0x80); //* 8bit. setara = 10000000 = 128
        $message .= pack('N2',0, $length << 3); //* 8bit ascii message has length = $length. | $length * 2^3 atau $length * 8;

        //! Process the message in successive 512-bit(64byte) chunks
        $chunks = str_split($message, 64);
        foreach($chunks as $chunk){
            $word = [];
            for ($i=0; $i < 16; $i++) { 
                extract(unpack('Ntemp',$this->stringShift($chunk,4)));
                $word[] = $temp;
            }
            // printf('WORD[15] => %08x <br>', $word[15]);

            //! Extend the sixteen 32-bit words into sixty-four 32-bit words
            for ($i=16; $i < 64; $i++) { 
                $s0 = $this->rightRotate($word[$i - 15],  7) ^ $this->rightRotate($word[$i - 15], 18) ^ $this->rightShift( $word[$i - 15],  3);
                $s1 = $this->rightRotate($word[$i - 2], 17) ^ $this->rightRotate($word[$i - 2], 19) ^ $this->rightShift( $word[$i - 2], 10);
                $word[$i] = $this->add($word[$i - 16], $s0, $word[$i - 7], $s1);
            }

            //! Initialize hash value for this chunk
            [$a,$b,$c,$d,$e,$f,$g,$h] = $hash;

            //! Main Loop
            for ($i = 0; $i < 64; $i++) {
                $s1 = $this->rightRotate($e,  6) ^ $this->rightRotate($e, 11) ^ $this->rightRotate($e, 25);
                $ch = ($e & $f) ^ ($this->not($e) & $g);
                $t1 = $this->add($h, $s1, $ch, $k[$i], $word[$i]); //* MAIN 1
                $s0 = $this->rightRotate($a,  2) ^ $this->rightRotate($a, 13) ^ $this->rightRotate($a, 22);
                $maj = ($a & $b) ^ ($a & $c) ^ ($b & $c);
                $t2 = $this->add($s0, $maj); //* MAIN 2

                $h = $g;
                $g = $f;
                $f = $e;
                $e = $this->add($d, $t1);
                $d = $c;
                $c = $b;
                $b = $a;
                $a = $this->add($t1, $t2);
            }

            $hash = [
                $this->add($hash[0], $a),
                $this->add($hash[1], $b),
                $this->add($hash[2], $c),
                $this->add($hash[3], $d),
                $this->add($hash[4], $e),
                $this->add($hash[5], $f),
                $this->add($hash[6], $g),
                $this->add($hash[7], $h)
            ];
            // printf('%x %x %x %x %x %x %x %x', $hash[0], $hash[1], $hash[2], $hash[3], $hash[4], $hash[5], $hash[6], $hash[7]);
            // echo '<br/> ======== NEW BLOCK ========= <br/>';
        }
        // printf('%x %x %x %x %x %x %x %x', $hash[0], $hash[1], $hash[2], $hash[3], $hash[4], $hash[5], $hash[6], $hash[7]);die;
        // return pack('H*', $hash[0], $hash[1], $hash[2], $hash[3], $hash[4], $hash[5], $hash[6], $hash[7]);
        $hash = $this->convertToHex($hash);
        return $hash;
    }

    public function convertTohex($arr){
        $hexString = '';
        foreach ($arr as $value ) {
            $hexString .= dechex($value);
            // echo $hexString;die;
        }
        return $hexString;
    }

    public function stringShift(&$string, $index = 1){
        $substr = substr($string, 0, $index);
        $string = substr($string, $index);
        return $substr;
    }

    public function rightRotate($int, $amt){
        //* int >> amt menghasilkan 0 bits diawalnya. 
        //* do bitwise OR (n >> amt) with n << (32 - amt) to get last amt bits
        $invamt = 32 - $amt;
        $mask = (1 << $invamt) - 1;
        return (($int << $invamt) & 0xFFFFFFFF) | (($int >> $amt) & $mask);
    }

    function rightShift($int, $amt){
        $mask = (1 << (32 - $amt)) - 1;
        return ($int >> $amt) & $mask;
    }

    public function add(){
        static $mod;
        if (!isset($mod)) {
            $mod = pow(2, 32);
        }

        $result = 0;
        $arguments = func_get_args();
        foreach ($arguments as $argument) {
            $result+= $argument < 0 ? ($argument & 0x7FFFFFFF) + 0x80000000 : $argument;
        }

        return fmod($result, $mod);
    }

    function not($int){
        return ~$int & 0xFFFFFFFF;
    }

}
