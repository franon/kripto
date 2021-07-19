@extends('layouts.master')
@section('title', 'Daftar Paket Klien')

@section('content')
<div class="col-md-12 col-sm-12  ">
    <div class="x_panel">
        <div class="x_title">
            <a href="{{ route('employee.daftar.klien.tambah') }}" class="btn btn-primary" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Buat Invoice Baru
            </a>
            <a href="{{ route('employee.daftar.tagihan.klien.cetak', ['klien_id'=>$klien->k_id]) }}" class="btn btn-success" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-cog" aria-hidden="true"></i>
              Generate Invoice Bulan {{ date('F Y') }}
          </a>
            @if ($klienTagihan == null)
            <h2>NO DATA</h2>
            @else
            <h2>{{ $klien->k_namalengkap }}</h2>
            @endif
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
                <th class="column-title">Nomor Tagihan </th>
                <th class="column-title">Total Tagihan </th>
                <th class="column-title">Tagihan Periode </th>
                <th class="column-title">Cetak Invoice </th>
                <th class="column-title no-link last"><span class="nobr">Action</span>
                </th>
                <th class="bulk-actions" colspan="7">
                  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                </th>
              </tr>
            </thead>

            <tbody>
              {{-- @dd($klienTagihan) --}}
              
              @if ($klienTagihan == null)
              <tr class="even pointer">
                <td class="a-center " colspan="8" style="text-align: center;"> NO DATA </td>
              </tr>
              @else
              @foreach ($klienTagihan as $klienTag)
              <tr class="even pointer">
                  <td class="a-center ">
                    <input type="checkbox" class="flat" name="table_records">
                  </td>
                  <td class=" ">{{$klienTag->k_namalengkap}}</td>
                  <td class=" ">
                    {{ $klienTag->tagihan_no }}
                      {{-- @php $tagihan = 0;@endphp --}}
                      {{-- @foreach ($klienTag->paket_internet as $p) --}}
                      {{-- {{$p['pinet_tipe']}} --}}
                      {{-- @php $tagihan += $p['pinet_harga']; @endphp --}}
                      {{-- <br> --}}
                      {{-- @endforeach --}}
                  </td>
                  <td class=" ">{{'Rp. '.number_format($klienTag->tagihan_total,0,'.','.')}}</td>
                  <td class=" ">{{$klienTag->tagihan_periode}}</td>
                  <td class=" "> <a href="{{ route('employee.daftar.tagihan.klien.tertentu', ['klien_id'=>$klienTag->k_id]) }}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> {{'Cetak PDF'}}</a></td>
                  <td class=" last"><button type="button" href="#" class="btn btn-warning">Edit</button> | <button type="button" href="#" class="btn btn-danger">Hapus</button></td>
                  </td>
                </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
                
            
      </div>
    </div>
  </div>
@endsection