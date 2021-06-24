<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employee\Drive\SimpleDrive;
use App\Http\Controllers\Encryption;
use App\Http\Controllers\Hashing;
use App\Models\Direktori;
use Dotenv\Parser\Parser;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Tcpdf\Fpdi;
use Smalot\PdfParser\Parser as PdfParserParser;
use TCPDF;

class DigitalSignature extends SimpleDrive
{
    // protected $user = Auth::user();
    public function show_FormSign(){
        $user = $this->sanitizeUser(Auth::user()); 
        return view('employee.file_processing.form-file-signing', compact('user'));
    }

    public function show_FormVerify(){
        $user = $this->sanitizeUser(Auth::user()); 
        return view('employee.file_processing.form-file-verifying', compact('user'));
    }
    
    public function createSign(Request $request){
        $user = $this->sanitizeUser(Auth::user()); 
        $rsa = new Encryption();
        $hash = new Hashing();
        $this->validate($request, [
            'file'=>'required|file|max:10240|mimes:pdf',
        ]);
        $file = $request->file;
        $defaultDirectory = 'signed/';

        //* 1. message_digest = sha256(M)
        // $md1 = hash('sha256', $this->extractDocument('pdf', $request->file->path()));
        $md = $hash->hash('sha256',$this->extractDocument('pdf', $file->path()));

        //* 2. digital_signature = RSA-1024(message_digest)
        $digitalSign = $rsa->createSignature($md); //? output digital_sign & pubkey

        //* 3. Attachment Digital sign into PDF
        $filename = $md.'.pdf'; $path = $defaultDirectory.$filename;
        $fileSignatured = $this->signDocument($file,$digitalSign,$path);

        //* 4. Upload File Signatured
        $this->uploadFiles($path,$fileSignatured);
        $directory = Direktori::firstWhere('dir_jalur','signed/');
        $directory->file()->create([
            'file_id'=>'file-'.sha1(md5(microtime(true))),
            'file_nama'=>$filename,
            'file_alias'=>$file->getClientOriginalName(),
            'file_tipe'=>$file->getClientOriginalExtension(),
            'file_jalur'=>$directory->dir_jalur,
            'file_jalurutuh'=>$path,
            'file_ukuran'=>$file->getSize(),
            'p_id'=>$user->p_id,
            'pembuat'=>$user->p_namapengguna,
            'tanggal_buat'=>date('Y-m-d'),
            'dir_nama'=>$directory->dir_nama
        ]);
        
        return redirect()->route('employee.drive');
    }

    public function internalCreateSign($file,$tagihan){
        $user = $this->sanitizeUser(Auth::user()); 
        $rsa = new Encryption();
        $hash = new Hashing();
        $defaultDirectory = 'signed/';

        //* 1. message_digest = sha256(M)
        // $md1 = hash('sha256', $this->extractDocument('pdf', $request->file->path()));
        $md = $hash->hash('sha256',$this->extractDocument('pdf', $file->path()));

        //* 2. digital_signature = RSA-1024(message_digest)
        $digitalSign = $rsa->createSignature($md); //? output digital_sign & pubkey

        //* 3. Attachment Digital sign into PDF
        $filename = $md.'.pdf'; $path = $defaultDirectory.$filename;
        $fileSignatured = $this->signDocument($file,$digitalSign,$path);

        //* 4. Upload File Signatured
        $this->uploadFiles($path,$fileSignatured);
        $directory = Direktori::find('dir-02');
        $directory->file()->create([
            'file_id'=>'file-'.sha1(md5(microtime(true))),
            'file_nama'=>$filename,
            'file_alias'=>$file->getClientOriginalName(),
            'file_tipe'=>'pdf',
            'file_jalur'=>$directory->dir_jalur,
            'file_jalurutuh'=>$path,
            'file_ukuran'=>filesize($file->path()),
            'p_id'=>$user->p_id,
            'pembuat'=>$user->p_namapengguna,
            'tanggal_buat'=>date('Y-m-d'),
            'dir_nama'=>$directory->dir_nama,
            'tagihan_id'=> $tagihan->tagihan_id
        ]);
        
        return redirect()->route('employee.drive');
    }

    public function verifySign(Request $request){
        $rsa = new Encryption();
        $hash = new Hashing();
        $this->validate($request, [
            'file'=>'required|file|max:10240',
        ]);

        //* 1. Separate signatures from documents
        [$document,$digitalSign] = $this->separateDocumentandSign($request->file->path());

        //* 2. M' = sha256(Document Digitalized)
        // $md = hash('sha256', $document);
        $md = $hash->hash('sha256',$document);

        //* 3. M'' = rsa_decrypt(digital_sign)
        // dd($md,$digitalSign);
        $md_needVerify = $rsa->verifySignature($digitalSign);

        //* 4. M' == M'' ?
        if($md != $md_needVerify) return 'Fake Document!';

        return 'Verified Document!';
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

    public function separateDocumentandSign($path){
        $parser = new PdfParserParser();
        $data = ''; $digitalSign = '';
        $pdf = $parser->parseFile($path);   
        $pages = $pdf->getPages();
        $totalPage = count($pages)-1;
        foreach ($pages as $idx => $page) {
            if ($idx == $totalPage) {
                $digitalSign = $page->getText();
                break;
            }
            $data .= $page->getText();
        }
        $data = preg_replace('/[\s|\t]+/','',$data);
        $digitalSign = preg_replace('/[\s|\t]+/','',$digitalSign);
        return [$data,$digitalSign];
    }
}
