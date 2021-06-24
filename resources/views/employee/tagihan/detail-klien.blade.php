@extends('layouts.master')

@section('title','Detail Klien')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <!-- Buat Folder -->
              <div class="btn-group">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPaketKlien"> <i class="fa fa-plus" aria-hidden="true"></i>Tambah Paket Klien</button>
              </div>
                <h2>Form Design</h2>
                <div class="clearfix"></div>

                <!-- Modal -->
              <div class="modal fade" id="addPaketKlien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Tambahkan Paket Klien</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{ route('employee.daftar.klien.tambah.paket.proses') }}">
                        @csrf
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="k_id">ID Klien <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="k_id" required="required" class="form-control" name="k_id" value="{{$klien->k_id}}" readonly>{{$klien->k_namalengkap}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="paket_internet">Daftar Paket Internet <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                            <input list="paket_internets" id="paket_internet" name="paket_internet" class="form-control"/>
                                <datalist id="paket_internets">
                                    @foreach ($paket_internet as $pinet)
                                    <option value="{{$pinet->pinet_id}}">{{$pinet->pinet_tipe}}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                      <button type="submit" class="btn btn-success" name="addPaketKlien">Tambah Paket Klien</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END of Modal -->

            </div>
            <div class="x_content">
                <br />
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{ route('employee.daftar.klien.tambah.proses') }}">
                    @csrf

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">username <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="username" required="required" class="form-control " name="username" value="{{$klien->k_namapengguna}}">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="namalengkap">Nama Lengkap <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="namalengkap" required="required" class="form-control" name="namalengkap" value="{{$klien->k_namalengkap}}">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="email" id="email" name="email" required="required" class="form-control" value="{{$klien->k_email}}">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="alamat" class="col-form-label col-md-3 col-sm-3 label-align">Alamat</label>
                        <div class="col-md-6 col-sm-6 ">
                            <textarea name="alamat" id="alamat" cols="30" rows="2" class="form-control">{{$klien->k_alamat}}</textarea>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="no_hp">No. Telp <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="no_hp" required="required" class="form-control" name="no_hp" value="{{$klien->no_hp}}">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="pinet">Paket digunakan <span class="required">*</span>
                        </label>
                        <ul class="list-group list-group-horizontal col-md-6 col-sm-6">
                        @foreach ($klien->paket_internet as $pinet)
                            <li class="list-group-item">{{$pinet->pinet_id.'|'.$pinet->pinet_tipe}}</li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Mulai Berlangganan <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="date" name="mulai_berlangganan" id="birthday" class="date-picker form-control" placeholder="yyyy-mm-dd" value="{{$klien->mulai_berlangganan}}" required="required">
                        </div>
                    </div>
                    {{-- <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="no_kontrak">No. Kontrak <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="no_kontrak" required="required" class="form-control" name="no_kontrak">
                        </div>
                    </div> --}}
                    <div class="ln_solid"></div>
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6 offset-md-3">
                            <button class="btn btn-primary" type="button">Cancel</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <button type="submit" class="btn btn-success" name="submit">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection