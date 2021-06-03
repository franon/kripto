<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employee\Drive\SimpleDrive;
use App\Http\Controllers\Encryption;
use App\Http\Controllers\Hashing;
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
        $user = Auth::user();
        return view('employee.file_processing.form-file-signing', compact('user'));
    }

    public function show_FormVerify(){
        $user = Auth::user();
        return view('employee.file_processing.form-file-verifying', compact('user'));
    }

    public function createSign(Request $request){
        $rsa = new Encryption();
        $hash = new Hashing();
        $this->validate($request, [
            'file'=>'required',
        ]);
        //* 1. message_digest = sha256(M)
        // $md1 = hash('sha256', $this->extractDocument('pdf', $request->file->path()));
        $md = $hash->hash('sha256',$this->extractDocument('pdf', $request->file->path()));


        //* 2. digital_signature = RSA-1024(message_digest)
        $digitalSign = $rsa->createSignature($md); //? output digital_sign & pubkey

        //* 3. Attachment Digital sign into PDF
        $fileSignatured = $this->signDocument($request->file,$digitalSign);

        //* 4. Upload File Signatured
        $this->uploadFiles($md.'.pdf',$fileSignatured,'signed');
        
        return redirect()->route('employee.drive');
    }

    public function verifySign(Request $request){
        $rsa = new Encryption();
        $hash = new Hashing();
        $this->validate($request, [
            'file'=>'required',
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

    public function signDocument($file, $digitalSign){
        $user = Auth::user();
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($file->path());

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($user->u_username);
        $pdf->SetTitle('Invoice-1');
        $pdf->SetSubject('Invoice perusahaan-X');
        $pdf->SetKeywords('Invoice, aprroved');

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
        $payload = storage_path('public/'.'pdf.pdf');
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

    public function verifyDocument($param){
        $aes = new Encryption();
        $keys = $aes->decrypt_AES($param);

        $rsa = new Encryption();
        $filename = $rsa->Decrypt_RSA($message,$keys);
        $filename = $filename.'pdf';

        return $this->downloadFiles($filename);
    }
}
