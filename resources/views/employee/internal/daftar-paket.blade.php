@extends('layouts.master')

@section('title','Daftar Paket Tersedia')

@section('content')
<div class="col-md-12 col-sm-12  ">
    <div class="x_panel">
        <div class="x_title">
            <a href="{{ route('employee.internal.paket_internet.tambah') }}" class="btn btn-primary" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Tambah Paket Internet
            </a>
            <h2>Daftar Paket Internet</h2>
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
                <th class="column-title">ID Paket Internet </th>
                <th class="column-title">Keterangan Paket Internet </th>
                <th class="column-title">Harga Paket Internet </th>
                <th class="column-title no-link last"><span class="nobr">Action</span>
                </th>
                <th class="bulk-actions" colspan="7">
                  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                </th>
              </tr>
            </thead>

            <tbody>
                @foreach ($paket as $pinet)
                <tr class="even pointer">
                    <td class="a-center ">
                      <input type="checkbox" class="flat" name="table_records">
                    </td>
                    <td class=" ">{{$pinet->pinet_id}}</td>
                    <td class=" ">{{$pinet->pinet_tipe}} </td>
                    <td class=" ">{{$pinet->pinet_harga}}</td>
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