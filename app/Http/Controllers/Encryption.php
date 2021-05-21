<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mylib\AES_Mode;
class Encryption extends Controller
{
    public function cobaenkrip_256($message){
        // $message = 'shockdartpesan01';
        $key = 'kuncifran!@#$%10kuncifran!@#$%10';
        $iv = 'abcdefghj1234567';
        
        $aes = new AES_Mode();
        // $cipher = $aes->Pure_Encrypt($message,$key); dd($cipher);
        // $cipher = $aes->CBC_Encrypt($message,$key,$iv); dd($cipher);
        // $message = $aes->Pure_Decrypt($cipher,$key);
        // dd($cipher,$message);

        $cipher = $aes->CBC_Encrypt($message, $key, $iv);
        return $cipher;

    }
    public function cobaenkrip(){
        $message = 'shockdartpesan01';
        $key = 'kuncifran!@#$%10';
        
        $aes = new AES_Mode();
        $cipher = $aes->Pure_Encrypt($message,$key);
        $message = $aes->Pure_Decrypt($cipher,$key);
        dd($cipher,$message);

    }

    public function EncryptFile_AES($path,$key){
        // $key = 'Thats my Kung Fu';
        $iv = 'abcdefghj1234567';
        list($file,$hash) = $this->fileHandler('open','pdf.pdf');
        
        $aes = new AES_Mode();
        $cipher = $aes->CBC_Encrypt($file,$key,$iv);
        
        $this->fileHandler('write','pdf-encrypted-cbc.pdf',$cipher);

    }

    public function DecryptFile_AES($path,$key){
        $iv = 'abcdefghj1234567';
        list($file,$hash) = $this->fileHandler('open','paper-1mb-encrypted-cbc.pdf');

        $aes = new AES_Mode();
        $message = $aes->CBC_Decrypt($file,$key,$iv);
        $this->fileHandler('write','paper-1mb-decrypted-cbc.pdf',$message);
        
    }

    public function EncryptPlaintext_AES(){

    }

    public function DecryptPlaintext_AES(){

    }

    public function Encrypt_RSA(){

    }

    public function Decrypt_RSA(){

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
                $hashed = hash("sha256",$tempFile);
                return [$tempFile,$hashed];
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
