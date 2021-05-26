<?php 
namespace App\Mylib;

class RsaEncryption 
{
    public function encrypt($message, $key){
        //! C = M^PU mod n
        [$pub,$totient_n,$bits] = $key;
        $input = $this->intoBlock($message,$bits); 
        $output = '';
        foreach ($input as $block) {
            if($block){
                $C = bcpowmod($this->txt2num($block),$pub,$totient_n);
                $output .= $C. " ";
            }
        }
        //* $C = bcpowmod($message,$pub,$totient_n);
        return base64_encode($output);
        
    }

    public function decrypt($cipher, $key){
        //! M = C^PK mod n
        [$exponent,$n] = $key;
        $input = explode(" ",base64_decode($cipher)); $output = '';
        foreach ($input as $block) {
            if($block){
                $M = $this->num2txt(bcpowmod($block,$exponent,$n));
                $output .= $M;
            }
        }
        return $output;
    }

    public function newKeyGen($bits){
        $starttime = microtime(true);
        while (true) {
            $p = gmp_strval(gmp_nextprime(gmp_random_range(bcpow(10,155-1),bcsub(bcpow(10,155),1))));
            $q = gmp_strval(gmp_nextprime(gmp_random_range(bcpow(10,155-1),bcsub(bcpow(10,155),1))));
            
            $n = bcmul($p,$q); //* Modulo
            $totient_n = bcmul(bcsub($p,1),bcsub($q,1));

            $e = 0x10001;
            $d = gmp_strval(gmp_gcdext($e,$totient_n)['s']);
            if($d<0) continue;
            
            $key = ['public'=>[$e,$n,$bits], 'private'=>[$d,$n,$bits]];
            break;
        }
        return $key;
    }

    //* Generate Key-pair
    public function keyGen($bits = 1024, $p = false, $q=false){
        $starttime = \microtime(true);
        //! Prime Numbers || P,Q 64byte/512 bit length || 155 digit
        $p = gmp_strval(gmp_nextprime(gmp_random_range(bcpow(10,155-1),bcsub(bcpow(10,155),1))));
        $q = gmp_strval(gmp_nextprime(gmp_random_range(bcpow(10,155-1),bcsub(bcpow(10,155),1))));
        // $p = generatePrime(ceil($bits/2));
        // $p = '13144131834269512219260941993714669605006625743172006030529504645527800951523697620149903055663251854220067020503783524785523675819158836547734770656069477';
        // $q = '12288506286091804108262645407658709962803358186316309871205769703371233115856772658236824631092740403057127271928820363983819544292950195585905303695015971';
        // dd($p,$q);

        //! MODULUS || N 128byte/1024 bit length || 309 digit
        $n = bcmul($p,$q); //* Modulo
        $totient_n = bcmul(bcsub($p,1),bcsub($q,1));

        //! PUBLIC EXPONENT
        $e = 0x10001; //* gcd($totient_n, e) = 1; || relative prime to $totient_n and <$totient_n || Must check with coprime and less than $totient_n  || 1<e<$totient_n

        //! PRIVATE EXPONENT
        //* de ≅ 1 (mod $totient_n) and d <$totient_n || using ext. Euclid's Algorithm || d = e^-1 mod $totient_n || d= ($totient_n * 1 + 1)/e
        $d = gmp_strval(gmp_gcdext($e,$totient_n)['s']);
        // $d = gmp_strval(gmp_abs(gmp_gcdext($e,$totient_n)['s']));
        $key = ['public'=>[$e,$n,$bits], 'private'=>[$d,$n,$bits]];
        // echo 'Blocking time: '. sprintf('%f (s)', \microtime(tr ue)-$starttime).'<br>';
        // dd($p,$q,$n,$totient_n,$e,$d, $key);
        echo json_encode([$totient_n,$d]);
        return $key;
    }

    public function txt2num($text){
        // $starttime = \microtime(true);
        $res = '';
        $n = strlen($text);
        // dd($n);

        //* x = 256*x + nextByte.
        for ($i=0; $i < $n ; $i++) { 
            $res = bcadd(bcmul($res, '256'), ord($text[$i]));
        }
        // echo 'txt2num: '. sprintf('%f (s)', \microtime(true)-$starttime).'<br>';
        return $res;
    }

    public function num2txt($num){
        $res = '';
        while (bccomp($num,'0')){
            $res .= chr(bcmod($num,'256')); //* x = x % 256; chr(x);
            $num = bcdiv($num,'256'); //* x = x/256;
        }
        return strrev($res);
    }

    public function intoBlock($input, $keysize){
        //? Calculate block-size based on length of keysize. 
        $byte = $keysize/8;
        return str_split($input,$byte); //? per128 byte or 128 char
    }

    //* Ext. Euclid or Multiplicative Inv
    // public function extGCD($a, $b){
    //     if ($a == 0){
    //         return $b, 0, 1;
    //     }else{
    //         $gcd = $this->extGCD($b % $a, $a);
    //         $x = $y - ($b/$a) $x;
    //         $y = $x;
    //     }
    // }

    //* Coprime Checker using gcd 
    public function gcd($a, $b){
        if($b == 0){
            return $a;
        }else{
            return $this->gcd($b, ($a % $b));
        }
    }

    //* Basic Prime Checker
    public function isPrime($num){
        $isPrime = true;
        // $iteration = 0;
        if($num == 0 || $num == 1){
            $isPrime = false;
        }else{
            for ($i=2;$i<=$num/2;++$i){
                // $iteration++;
                if($num % $i == 0){
                $isPrime = false;
                break;
                }
            }
        }
        return $isPrime;
    }
}