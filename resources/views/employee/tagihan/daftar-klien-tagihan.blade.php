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

        @if ($errors->all())
        {{-- @dd($errors) --}}
        <div class="alert alert-danger" style="width: 50%"><h4>{{$errors->first()}}</h4></div>
        @endif
        <div class="table-responsive">
          <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr class="headings">
                <th>
                  <input type="checkbox" id="check-all" class="flat">
                </th>
                <th class="column-title">Nama Klien </th>
                <th class="column-title">Paket terdaftar </th>
                <th class="column-title">Estimasi Tagihan </th>
                <th class="column-title">Mulai Berlangganan </th>
                <th class="column-title">Cetak Invoice </th>
                <th class="column-title no-link last"><span class="nobr">Action</span>
                </th>
                <th class="bulk-actions" colspan="7">
                  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                </th>
              </tr>
            </thead>

            <tbody>
                @foreach ($klienberlangganan as $k)
                <tr class="even pointer">
                    <td class="a-center ">
                      <input type="checkbox" class="flat" name="table_records">
                    </td>
                    <td class=" ">{{$k['k_namalengkap']}}</td>
                    <td class=" ">
                        @php $tagihan = 0;@endphp
                        @foreach ($k['paket_internet'] as $p)
                        {{$p['pinet_tipe']}}
                        @php $tagihan += $p['pinet_harga']; @endphp
                        <br>
                        @endforeach
                    </td>
                    <td class=" ">{{'Rp. '.number_format($tagihan,0,'.','.')}}</td>
                    <td class=" ">{{$k['mulai_berlangganan']}}</td>
                    <td class=" "> <a href="{{ route('employee.daftar.klien.tagihan.cetak', ['klien_id'=>$k['k_id']]) }}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> {{'Cetak PDF'}}</a></td>
                    <td class=" last"><a href="#">Detail</a>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
        </div>
                
            
      </div>
    </div>
  </div>
@endsection