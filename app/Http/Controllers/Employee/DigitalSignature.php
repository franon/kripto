<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Encryption;
use App\Mylib\RsaEncryption;
use Dotenv\Parser\Parser;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use setasign\Fpdi\Tcpdf\Fpdi;
use Smalot\PdfParser\Parser as PdfParserParser;
use TCPDF;

class DigitalSignature extends Controller
{
    public function show_FormSign(){
        $user = Auth::user();
        return view('employee.file_processing.form-file-signing', compact('user'));
    }
    public function createSign(Request $request){
        $rsa = new Encryption();
        $this->validate($request, [
            'file'=>'required',
        ]);
        $md = hash('sha256', $this->extractDocument('pdf', $request->file->path()));
        [$digitalSign,$keys] = $rsa->createSignature($md);
        // dd($keys);
        // echo 'Time elapsed: '. sprintf('%f (s)', \microtime(true)-$starttime).'<br>';
        $fileSignatured = $this->signDocument($request->file,$digitalSign,json_encode($keys));
        return $fileSignatured;
    }

    public function verifySign($fileSignatured,$keys){
        $rsa = new Encryption();
        [$document,$digitalSign] = $this->separateDocumentandSign($fileSignatured);
        $md = hash('sha256', $this->extractDocument('pdf','invoice.pdf'));

        $md_needVerify = $rsa->verifySignature($digitalSign,$keys);

        if($md != $md_needVerify) return 'Fake Document!';

        return 'Verified Document!';
    }

    public function extractDocument($fileType, $path){
        
        $parser = new PdfParserParser();
        $data = '';
        switch ($fileType) {
            case 'pdf':
                $pdf = $parser->parseFile($path);
                $pages = $pdf->getPages();
                foreach($pages as $page){
                    $data .= $page->getText();
                }
                // echo $data; die;
                return base64_encode($data);
            
            default:
                return false;
        }
    }

    public function signDocument($file, $digitalSign,$keys){
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
        $payload = '[111011101110111][010010001000010][010011001110010][010010000010010][010011101110010]';
        $pdf->write2DBarcode($payload, 'QRCODE,H', 20, 245, 30, 30, $style, 'N');
        $pdf->Text(20, 213, 'Scan QR Untuk Validasi');
        $pdf->Output($file->getClientOriginalName());
    }
}
