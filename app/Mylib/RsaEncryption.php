<?php 
namespace App\Mylib;

class RsaEncryption 
{
    public function encrypt($message, $key){
        
        //! C = M^PU mod n
        list($pub,$totient_n,$bits) = $key;
        $input = $this->intoBlock($message,$bits); $output = '';
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
        list($priv,$totient_n) = $key;
        // echo (base64_decode($cipher));die;
        $input = explode(" ",base64_decode($cipher)); $output = '';
        foreach ($input as $block) {
            // echo 'block ke- '.$block;
            if($block){
                $M = $this->num2txt(bcpowmod($block,$priv,$totient_n));
                $output .= $M;
            }
        }
        // die;
        // $M = ($cipher**$priv)%$totient_n;
        // $D = bcpowmod($cipher,$priv,$totient_n);

        return $output;
    }

    //* Generate Key-pair
    public function keyGen($bits = 1024, $p = false, $q=false){
        //! Prime Numbers || P,Q 64byte/512 bit length || 155 digit
        // $p=gmp_nextprime(random_int(100,10000));
        // $q=gmp_nextprime(random_int(100,10000));
        // $p = generatePrime(ceil($bits/2));
        $p = '13144131834269512219260941993714669605006625743172006030529504645527800951523697620149903055663251854220067020503783524785523675819158836547734770656069477';
        $q = '12288506286091804108262645407658709962803358186316309871205769703371233115856772658236824631092740403057127271928820363983819544292950195585905303695015971';

        //! MODULUS || N 128byte/1024 bit length || 309 digit
        // $n = $p * $q;
        $n = bcmul($p,$q);
        // $totient_n = ($p-1)*($q-1); //* Modulo
        $totient_n = bcmul(bcsub($p,1),bcsub($q,1));

        //! PUBLIC EXPONENT
        // $e_temp1 = 17;
        $e = 0x10001; //* gcd($totient_n, e) = 1; || relative prime to $totient_n and <$totient_n || Must check with coprime and less than $totient_n  || 1<e<$totient_n

        //! PRIVATE EXPONENT
        //$d_temp1 = 2753; //* de ≅ 1 (mod $totient_n) and d <$totient_n || using ext. Euclid's Algorithm || d = e^-1 mod $totient_n || d= ($totient_n * 1 + 1)/e
        $d = gmp_gcdext($e,$totient_n)['s'];
        $key = ['public'=>[$e,$n,$bits], 'private'=>[$d,$n,$bits]];
        // var_dump($key);die;
        
        return $key;
    }

    public function txt2num($text){
        $res = '';
        $n = strlen($text);

        //* x = 256*x + nextByte.
        for ($i=0; $i < $n ; $i++) { 
            $res = bcadd(bcmul($res, '256'), ord($text[$i]));
        }
        
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
        return str_split($input,$byte);
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
        if(b == 0){
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