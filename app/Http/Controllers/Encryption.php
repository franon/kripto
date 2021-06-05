<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mylib\AES_Mode;
use App\Mylib\RsaEncryption;
use Exception;

class Encryption extends Controller
{
    public function cobaenkrip_256($message=false){
        // echo 'Blocking time: '. sprintf('%f (s)', \microtime(true)-$starttime).'<br>';
        $message = 'shockdartpesan01';
        $key = 'kuncifran!@#$%10kuncifran!@#$%10';
        // $key = [0x0f,0x15,0x71,0xc9,0x47,0xd9,0xe8,0x59,0x0c,0xb7,0xad,0xd6,0xaf,0x7f,0x67,0x98,0x0f,0x15,0x71,0xc9,0x47,0xd9,0xe8,0x59,0x0c,0xb7,0xad,0xd6,0xaf,0x7f,0x67,0x98];
        $iv = 'c0~JO&HN+~!!zMyh';
        $aes = new AES_Mode();
        // $cipher = $aes->Pure_Encrypt($message,$key); 
        // $message = $aes->Pure_Decrypt($cipher,$key);
        $message = $this->fileHandler('open','word.docx');
        $starttime = microtime(true);
        $cipher = $aes->Pure_Encrypt($message,$key);
        $message = $aes->Pure_Decrypt($cipher,$key);
        dd(\microtime(true)-$starttime,$message);
        dd($cipher,$message);

        // $cipher = $aes->CBC_Encrypt($message, $key, $iv);
        // return $cipher;

    }
    public function cobaenkrip_RSA(enkripsirsa $rsa){
        $message = 'shockdartpesan01';
        $key = 'kuncifran!@#$%10';
        $rsa_1024 = $rsa->encrypt();
    }

    public function encrypt_AES($message){
    
        $key = 'kuncifran!@#$%10kuncifran!@#$%10';
        $iv = 'c0~JO&HN+~!!zMyh';
        // $message = 'shockdartpesan01';
        $aes = new AES_Mode();
        $cipher = $aes->CBC_Encrypt($message,$key,$iv);
    
        // dd($cipher);
        return $cipher;
    }

    public function decrypt_AES($cipher){
    $message = '';
        // try {
            $key = 'kuncifran!@#$%10kuncifran!@#$%10';
            $iv = 'c0~JO&HN+~!!zMyh';
            $aes = new AES_Mode();
            $message = $aes->CBC_Decrypt($cipher,$key,$iv);
        // } catch (Exception $e) {
            // return abort(404);
            // echo $e->getMessage(); die;
        // }
        return $message;
    }

    public function EncryptPlaintext_AES(){
        echo "test";
    }

    public function DecryptPlaintext_AES(){
        $key = 'kuncifran!@#$%10kuncifran!@#$%10';
        $iv = 'c0~JO&HN+~!!zMyh';
        $aes = new AES_Mode();
    }

    public function createSignature($message){
        $rsa_1024 = new RsaEncryption();
        $keys = $rsa_1024->newKeyGen('1024');
        // $message = hash('hash256','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec. Vitae tortor condimentum lacinia quis vel eros donec ac odio. Habitant morbi tristique senectus et.');
        $sign = $rsa_1024->encrypt($message,$keys['private']);
        $keys = implode(".",$keys['public']);
        $sign = base64_encode($sign.'.'.$keys);
        return $sign;
    }

    public function verifySignature($sign){
        $rsa_1024 = new RsaEncryption();
        $sign = \base64_decode($sign);
        [$md, $pubkey, $modulus] = explode(".",$sign);
        $keys = [$pubkey,$modulus];
        $md = $rsa_1024->decrypt($md, $keys);
        return $md;
    }

    public function Encrypt_RSA(){
        $rsa_1024 = new RsaEncryption();
        $keys = $rsa_1024->keyGen('1024');
        $message = hash('hash256','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec. Vitae tortor condimentum lacinia quis vel eros donec ac odio. Habitant morbi tristique senectus et.');

        $encrypt = $rsa_1024->encrypt($message,$keys['public']);
    }

    public function Decrypt_RSA($message,$keys){
        $rsa_1024 = new RsaEncryption();
        $message = $rsa_1024->decrypt($message,$keys);
        return $message;
    }

    public function fileHandler($type,$filename=false,$content=false){
        $chunkSize = 1024*1024;
        $tempFile = '';

        
        switch ($type) {
            case 'open':
                $filename = "../storage/app/bahantest/".$filename;
                $handle = fopen($filename,'r');
                while(!feof($handle)){
                    $line = fread($handle, $chunkSize);
                    $tempFile .= $line;
                }
                fclose($handle);
                return $tempFile;
                // $hashed = hash("sha256",$tempFile);
                // return [$tempFile,$hashed];
                // return [base64_encode($tempFile),$hashed];

            // case 'write':
            //     $file = fopen(base_path('storage\app\bahantest\text-encrypted.txt'),'w');
            //     for ($written=0; $written < strlen($content); $written += $fwrite) { 
            //         echo 'ke-'.$written;
            //         $fwrite = fwrite($file,substr($content, $written));
            //         // if($fwrite === false) var_dump($written,'ini nih');die;
            //         if($fwrite === false) return $written;
            //     }
            //     $hashed = hash("sha256", $written);
            //     return [$written,$hashed];
            
            case 'write':
                $lenContent = strlen($content);
                if($lenContent < 1) return false;
                $filename = "../storage/app/bahantest/".$filename;
                $handle = fopen($filename,'w');
                $len = $lenContent;
                $writtenTotal = 0;
                while($writtenTotal < $lenContent){
                    $written = fwrite($handle, $content);
                    // echo $written;
                    if($written == $lenContent) return;
                    if($written < 1) return "could only write. $written/$lenContent. bytes!";
                    
                    $writtenTotal += $written;
                    $content =  substr($content, $written);
                    $len -= $written;
                    fclose($handle);
                }

            default:
                return false;
        }

    }

}
