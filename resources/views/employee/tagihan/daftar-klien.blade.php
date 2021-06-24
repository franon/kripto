@extends('layouts.master')

@section('title','Daftar Klien')

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
          <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr class="headings">
                <th>
                  <input type="checkbox" id="check-all" class="flat">
                </th>
                <th class="column-title">Nama Klien </th>
                <th class="column-title">Alamat Klien </th>
                <th class="column-title">Kontak Klien </th>
                <th class="column-title">Mulai Berlangganan </th>
                <th class="column-title">No. Kontrak </th>
                <th class="column-title no-link last"><span class="nobr">Action</span>
                </th>
                <th class="bulk-actions" colspan="7">
                  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                </th>
              </tr>
            </thead>

            <tbody>
                @foreach ($klien as $k)
                <tr class="even pointer">
                    <td class="a-center ">
                      <input type="checkbox" class="flat" name="table_records">
                    </td>
                    <td class=" ">{{$k->k_namalengkap}}</td>
                    <td class=" ">{{$k->k_alamat}} </td>
                    <td class=" ">{{$k->no_hp}} <i class="success fa fa-long-arrow-up"></i></td>
                    <td class=" ">{{$k->mulai_berlangganan}}</td>
                    <td class=" ">{{$k->no_kontrak}}</td>
                    <td class=" last"><a href="{{route('employee.daftar.klien.detail',['k_id'=>$k->k_id])}}">Detail</a>
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