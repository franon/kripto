<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Employee\Drive\SimpleDrive;
use App\Http\Controllers\Encryption;
use App\Http\Controllers\Hashing;
use App\Models\Direktori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Smalot\PdfParser\Parser as PdfParserParser;
use setasign\Fpdi\Tcpdf\Fpdi;

class MultiSec extends SimpleDrive
{
    public function show_FormMultiSec(){
        $user = $this->sanitizeUser(Auth::user()); 
        return view('employee.file_processing.form-file-multi-sec', compact('user'));
    }

    public function process_MultiSec(Request $request){
        $user = $this->sanitizeUser(Auth::user());
        $this->validate($request, [
            'file'=>'required|file|max:10240|mimes:pdf',
            'kunci'=>'required|size:32'
        ]);

        $file = $request->file;

        [$path,$filename,$fileSignatured] = $this->signing($file,$user);
        $fileSignaturedEncrypted = $this->encryption($fileSignatured,$request->kunci);

        $this->uploadFiles($path, $fileSignaturedEncrypted);
        $directory = Direktori::find('encrypted/signed/');
        $directory->file()->create([
            'file_id'=>'file-'.sha1(md5(microtime(true))),
            'file_nama'=>$filename,
            'file_alias'=>$file->getClientOriginalName(),
            'file_tipe'=>$file->getClientOriginalExtension(),
            'file_jalur'=>'encrypted/signed/',
            'file_jalurutuh'=>$path,
            'file_ukuran'=>$file->getSize(),
            'p_id'=>$user->p_id,
            'pembuat'=>$user->p_namapengguna,
            'tanggal_buat'=>date('Y-m-d'),
            'dir_nama'=>$directory->dir_nama
        ]);

        return redirect()->route('employee.drive');
    }

    public function signing($file, $user){
        $rsa = new Encryption();
        $hash = new Hashing();
        $defaultDirectory = 'encrypted/signed/';

        //* 1. message_digest = sha256(M)
        // $md1 = hash('sha256', $this->extractDocument('pdf', $request->file->path()));
        $md = $hash->hash('sha256',$this->extractDocument('pdf', $file->path()));

        //* 2. digital_signature = RSA-1024(message_digest)
        $digitalSign = $rsa->createSignature($md); //? output digital_sign & pubkey

        //* 3. Attachment Digital sign into PDF
        $filename = $md.'.pdf'; $path = $defaultDirectory.$filename;
        $fileSignatured = $this->signDocument($file,$digitalSign,$path);

        // //* 4. Upload File Signatured
        // $this->uploadFiles($path,$fileSignatured);
        // $directory = Direktori::find('dir-03');
        // $directory->file()->create([
        //     'file_id'=>'file-'.sha1(md5(microtime(true))),
        //     'file_nama'=>$filename,
        //     'file_alias'=>$file->getClientOriginalName(),
        //     'file_tipe'=>$file->getClientOriginalExtension(),
        //     'file_jalur'=>$directory->dir_jalur,
        //     'file_jalurutuh'=>$path,
        //     'file_ukuran'=>$file->getSize(),
        //     'p_id'=>$user->p_id,
        //     'pembuat'=>$user->p_namapengguna,
        //     'tanggal_buat'=>date('Y-m-d'),
        //     'dir_nama'=>$directory->dir_nama
        // ]);

        return [$path,$filename,$fileSignatured];
    }

    public function encryption($content, $kunci){
        $encryption = new Encryption();
        $encrypted = $encryption->encrypt_AES($content, $kunci);
        return $encrypted;
    }

    public function signDocument($file, $digitalSign,$path){
        $user = $this->sanitizeUser(Auth::user()); 
        $pdf = new Fpdi();
        $filename = base64_encode($path);
        $pageCount = $pdf->setSourceFile($file->path());

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($user->p_namapengguna);
        $pdf->SetTitle('Invoice-1');
        $pdf->SetSubject('Invoice perusahaan-X');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        for ($pageNo=1; $pageNo <= $pageCount; $pageNo++) { 
            $templateId = $pdf->importPage($pageNo);
            $pdf->AddPage();
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

            $pdf->SetFont('Helvetica');
            $pdf->SetXY(5, 5);
            // $pdf->Write(8, 'A complete document imported with FPDI');
        }

        $style = [
            'border' => false,
            // 'vpadding' => 'auto',
            // 'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        ];
        $payload = route('public.download',['penentu'=>'signed','filename'=>$filename]);
        // dd($payload);
        $pdf->write2DBarcode($payload, 'QRCODE,H', 20, 245, 30, 30, $style, 'N');
        // $pdf->Text(20, 213, 'Scan QR Untuk Validasi');
        $pdf->AddPage();
        $html = <<<EOD
        <p> $digitalSign </p>
        EOD;
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $file = $pdf->Output($file->getClientOriginalName(),'S');
        return $file;
    }

    public function extractDocument($fileType, $path){
        
        $parser = new PdfParserParser();
        $data = '';
        switch ($fileType) {
            case 'pdf':
                $pdf = $parser->parseFile($path);
                $data = $pdf->getText();
                $data = preg_replace('/[\s|\t]+/','',$data);
                return $data;
            
            default:
                return false;
        }
    }

}
