<?php

namespace App\Http\Controllers\employee\tagihan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employee\DigitalSignature;
use App\Models\Klien;
use App\Models\Paket_Internet;
use App\Models\Tagihan_Klien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use TCPDF;
use App\Mylib\customPDF;
use Hamcrest\Type\IsObject;
use Illuminate\Support\Facades\Storage;
use stdClass;

class DaftarKlien extends Controller
{
    public function showDaftarKlien(){
        $user = Auth::user();
        $klien = Klien::all();
        return view('employee.tagihan.daftar-klien',compact('user','klien'));
    }

    public function showCreateDataKlien(){
        $user = Auth::user();
        $paket_internet = Paket_Internet::all();
        return view('employee.tagihan.klien-tambah',compact('user','paket_internet'));
    }

    public function createDataKlien(Request $request){
        $this->validate($request,[
            'username'=>'required',
            'namalengkap'=>'required',
            'email'=>'required|email',
            'mulai_berlangganan'=>'required'
        ]);
        $daftarPaketInternet = Paket_Internet::find($request->paket_internet)->first();
        $klien = Klien::create([
            'k_namapengguna'=>$request->username,
            'k_namalengkap'=>$request->namalengkap,
            'k_email'=>$request->email,
            'k_password'=>Hash::make($request->username),
            'k_alamat'=>$request->alamat,
            'no_hp'=>$request->no_hp,
            'mulai_berlangganan'=>$request->mulai_berlangganan
        ]);
        $lastID = $klien->k_id;
        $klien = Klien::find($lastID);
        $klien->no_kontrak = $lastID.'/GMDP'; $klien->save();

        
        $klien = Klien::find($lastID);
        $klien->paket_internet()->attach($daftarPaketInternet->pinet_id,[
            'pk_id'=>'pk-'.sha1(md5(microtime(true))),
            'pk_no'=>'pk-gmdp-'.$lastID,
            'pk_harga'=> $daftarPaketInternet->pinet_harga
        ]);

        return \redirect()->route('employee.daftar.klien');
    }

    public function showDaftarKlienTagihan(){
        $user = Auth::user();
        $klienberlangganan = [];
        $seluruhKlien = Klien::with('paket_internet')->get();
        foreach ($seluruhKlien as $idx_k => $klien) {
            $klienberlangganan[$idx_k] = [
                    'k_id'=>$klien->k_id,
                    'k_namalengkap'=>$klien->k_namalengkap,
                    'mulai_berlangganan'=>$klien->mulai_berlangganan,
                    'no_kontrak'=>$klien->no_kontrak,
            ];
            foreach ($klien->paket_internet as $idx_p => $paketnya){
                $klienberlangganan[$idx_k]['paket_internet'][$idx_p] = [
                    'pinet_id'=>$paketnya->pinet_id,
                    'pinet_tipe'=>$paketnya->pinet_tipe,
                    'pinet_harga'=>$paketnya->pinet_harga,
                ];
            }
        }
        // return $klienberlangganan;
        return view('employee.tagihan.daftar-klien-tagihan',compact('user','klienberlangganan'));
    }

    public function cetakPDFKlienTagihan($klien_id){
      $digitalsigning = new DigitalSignature();
      $user = Auth::user();
      $klien = Klien::find($klien_id);
      $result = $klien->toArray();$result['tagihan'] = 0;
      $result['tagihan_no'] = $result['no_kontrak'].'/'.date("ym");
      if(Tagihan_Klien::where('tagihan_no',$result['tagihan_no'])->exists()) return redirect()->back()->withErrors('Invoice klien ['.$result["k_namalengkap"].'] sudah ada');

      foreach ($klien->paket_internet as $idx => $paket) {
          $result['paket'][$idx]['pinet_id'] = $paket->pinet_id;
          $result['paket'][$idx]['pinet_tipe'] = $paket->pinet_tipe;
          $result['paket'][$idx]['pinet_harga'] = $paket->pinet_harga;
          $result['paket'][$idx]['pk_no'] = $paket->pivot->pk_no;
          $result['paket'][$idx]['pk_harga'] = $paket->pivot->pk_harga;
          $result['tagihan'] += $paket->pivot->pk_harga;
      }

      $result['ppn'] = ($result['tagihan']*10/100);
      $result['totalTagihan'] = $result['tagihan']+$result['ppn'];
      // return $result;

      [$filename,$path] = $this->coreCetakPDFbyTCPDF($user,$result);
      $file = new class($filename,$path){
        private $path;
        private $filename;
              
        public function __construct($filename, $path) {
          $this->path = $path;
          $this->filename = $filename;
        }

        public function path(){
          return $this->path;
        }

        public function getClientOriginalName(){
          return $this->filename;
        }
      };

      $tagihan = Tagihan_Klien::create([
        'tagihan_no'=>$result['tagihan_no'],
        'tagihan_periode'=>date("ym"),
        'tagihan_ppn'=>$result['ppn'],
        'tagihan_total'=>$result['totalTagihan'],
        'status_bayar'=>0,
        'pk_no'=>$result['paket'][0]['pk_no'],
        'k_id'=>$result['k_id'],
      ]);
      
      $digitalsigning->internalCreateSign($file,$tagihan);

      Storage::disk('frandrive')->delete('signed/'.$filename);

      return redirect()->route('employee.daftar.klien.tagihan');



        
    }

    public function coreCetakPDFbyTCPDF($user,$result) {
      $pdf = new customPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor($user->p_namapengguna);
      $pdf->SetTitle('Invoice');
      $pdf->SetSubject('Invoice');

      // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'PT. Global Media Data Prima', '');
      // dd(asset('images/gmdp-logo.png'));
      // $pdf->setFooterData(array(0,64,0), array(0,64,128));

      // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 20));
      // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      // $pdf->SetFooterMargin('20');

      // $pdf->setPrintFooter(false);

      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      $pdf->SetFont('helvetica', '', 10);

      $pdf->AddPage();
      $html = '
                <h1>INVOICE</h1>

                <table border="1" cellspacing="2" cellpadding="2" style="width:35%; float:right;">

                  <tr>
                    <th bgcolor="#DAD9D7" align="center"> Kode Pelanggan / Customer ID</th>
                  </tr>
                  <tr>
                    <td align="center">'.$result['k_id'].'</td>
                  </tr>
                </table>
                <p></p>
                <table border="1" cellspacing="3" cellpadding="4" style="width: 100%">

                  <tr>
                    <th bgcolor="#DAD9D7" align="center"> Nomor / Number</th>
                    <th bgcolor="#DAD9D7" align="center">Tanggal Cetak Tagihan / Statement Date</th>
                    <th bgcolor="#DAD9D7" align="center">Tanggal Jatuh Tempo / Due Date</th>
                    <th bgcolor="#DAD9D7" align="center">No. Kontrak / Contract No. </th>
                    <th bgcolor="#DAD9D7" align="center">Total Tagihan / Total Amount </th>
                    <th bgcolor="#DAD9D7" align="center">NPWP / NIK </th>
                  </tr>
                  <tr>
                    <td align="center">'.$result['tagihan_no'].'</td>
                    <td align="center">'.date("d F Y").'</td>
                    <td align="center">'.date('j F Y',strtotime('2021-06-10')).'</td>
                    <td align="center">'.$result['no_kontrak'].'</td>
                    <td align="center">'.$result['totalTagihan'].' </td>
                    <td align="center"> -  </td>
                  </tr>
                </table>
                
                <p style="margin: 0; padding: 0; margin-top: 20px;">Kepada / To.</p>
                <p style="margin: 0; padding: 0;">'.$result['k_namalengkap'].'</p>
                <p style="margin-bottom: 20px;">'.$result['k_alamat'].'</p>
                

                <table border="1" cellspacing="3" cellpadding="4" style="width: 100%">

                  <tr>
                    <th bgcolor="#DAD9D7">Keterangan/ Description</th>
                    <th bgcolor="#DAD9D7">Periode / Period</th>
                    <th bgcolor="#DAD9D7">Pemakaian / Usage</th>
                    <th bgcolor="#DAD9D7">Total (Rupiah) </th>
                  </tr>
              ';
      foreach ($result['paket'] as $idx => $paket) {
        $html .= '
                <tr>
                      <td height="50" align="center">'.$paket['pinet_tipe'].'</td>
                      <td height="50" align="center">'.date('F Y').'</td>
                      <td height="50" align="center">1 bulan</td>
                      <td height="50" align="right">'.$paket['pk_harga'].'</td>
                </tr>
              ';
      }
        $html .= '
                  <tr>
                    <td style=" border-style: hidden; border-left-style: hidden; border-bottom-style: hidden;"></td>
                    <td style=" border-style: hidden; border-left-style: hidden; border-bottom-style: hidden;"></td>
                    <td>Sub Total</td>
                    <td align="right">'.$result["tagihan"].'</td>
                  </tr>
                  <tr>
                    <td style=" border-style: hidden; border-left-style: hidden; border-bottom-style: hidden;"></td>
                    <td style=" border-style: hidden; border-left-style: hidden; border-bottom-style: hidden;"></td>
                    <td>PPN 10%</td>
                    <td align="right">'.$result["ppn"].'</td>
                  </tr>
                  <tr>
                    <td style=" border-style: hidden; border-left-style: hidden; border-bottom-style: hidden;"></td>
                    <td style=" border-style: hidden; border-left-style: hidden; border-bottom-style: hidden;"></td>
                    <td><strong>Total Tagihan</strong></td>
                    <td align="right"><strong>'.$result["totalTagihan"].'</strong></td>
                  </tr>
                </table>

                <p>Transfer Pembayaran dapat melalui Bank:</p>

                <p style="margin: 0; padding: 0;">Bank: Bank Central Asia</p>
                <p style="margin: 0; padding: 0;">Acc. No.: 785.0836.161 (Rupiah)</p>
                <p>Name. : PT Global Media Data Prima</p>
                
                

                <i>Mohon mencantumkan ID Pelangggan saat melalukan pembayaran via Bank atau mengirimkan bukti pembayaran.</i>
                <p>Terimakasih atas kerjasamanya. </p>
            ';

      $pdf->writeHTML($html,true,false, true, false, '');
      $pdf->lastPage();
      // dd(storage_path('app/encryptstorage/signed/'.'Inv-'.base64_encode($result['tagihan_no'])));
      $filename = 'Inv-'.str_replace(' ','',$result['k_namalengkap']).'.pdf';
      $path = storage_path('app/encryptstorage/signed/'.$filename);
      $pdf->Output($path, 'F');
      return [$filename,$path];
    }

}
