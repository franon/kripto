@extends('layouts.master')
@section('title', 'Daftar Paket Klien')

@section('content')
<div class="col-md-12 col-sm-12  ">
    <div class="x_panel">
        <div class="x_title">
            <a href="{{ route('employee.daftar.klien.tambah') }}" class="btn btn-primary" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Tambah Klien
            </a>
            <h2>Daftar pelanggan</h2>
            <div class="clearfix"></div>
        </div>

      <div class="x_content">

        <div class="table-responsive">
          
          <h1>INVOICE</h1>

          <table border="1" cellspacing="3" cellpadding="4" style="width: 100%">

            <tr>
              <th>Nomer/Number</th>
              <th>Tanggal Cetak Tagihan / Statement Date</th>
              <th>Tanggal Jatuh Tempo / Due Date</th>
              <th>No. Kontrak / Contract No. </th>
              <th>Total Tagihan / Total Amount </th>
              <th>NPWP / NIK </th>
            </tr>
            <tr>
              <td>Nomer/Number</td>
              <td>Tanggal Cetak Tagihan / Statement Date</td>
              <td>Tanggal Jatuh Tempo / Due Date</td>
              <td>No. Kontrak / Contract No. </td>
              <td>Total Tagihan / Total Amount </td>
              <td>NPWP / NIK </td>
            </tr>
          </table>

          <p style="margin: 0; padding: 0; margin-top: 20px;">Kepada / To.</p>
          <p style="margin: 0; padding: 0;">Abdul Wahid</p>
          <p style="margin-bottom: 20px;">Bumi Sakinah 4 Blok C</p>
          

          <table border="1" cellspacing="3" cellpadding="4" style="width: 100%">

            <tr>
              <th>Keterangan/ Description</th>
              <th>Periode / Period</th>
              <th>Pemakaian / Usage</th>
              <th>Total (Rupiah) </th>
            </tr>
            <tr>
              <td>3mbps</td>
              <td>juni 2021</td>
              <td>1 bulan</td>
              <td>120000</td>
            </tr>
            <tr>
              <td style="border-left-style: hidden; border-bottom-style: hidden;">&nbsp</td>
              <td style="border-left-style: hidden; border-bottom-style: hidden;">&nbsp</td>
              <td>Sub Total</td>
              <td>120000</td>
            </tr>
            <tr>
              <td style="border-left-style: hidden; border-bottom-style: hidden;">&nbsp</td>
              <td style="border-left-style: hidden; border-bottom-style: hidden;">&nbsp</td>
              <td>PPN 10%</td>
              <td>12000</td>
            </tr>
            <tr>
              <td style="border-left-style: hidden; border-bottom-style: hidden;">&nbsp</td>
              <td style="border-left-style: hidden; border-bottom-style: hidden;">&nbsp</td>
              <td><strong>Total Tagihan</strong></td>
              <td><strong>120000</strong></td>
            </tr>
          </table>

          <p>Transfer Pembayaran dapat melalui Bank:</p>

          <p style="margin: 0; padding: 0;">Bank: Bank Central Asia</p>
          <p style="margin: 0; padding: 0;">Acc. No.: 785.0836.161 (Rupiah)</p>
          <p>Name. : PT Global Media Data Prima</p>
          
          

          <i>Mohon mencantumkan ID Pelangggan saat melalukan pembayaran via Bank atau mengirimkan bukti pembayaran.</i>
          <p>Terimakasih atas kerjasamanya. </p>

        </div>
                
            
      </div>
    </div>
  </div>
@endsection