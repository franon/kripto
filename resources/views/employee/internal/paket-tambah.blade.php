@extends('layouts.master')

@section('title','Tambah Data Paket Internet')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title" >
                <h2>Paket Internet</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{ route('employee.internal.paket_internet.tambah.proses') }}">
                    @csrf

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="pinet_id">ID Paket Internet <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="pinet_id" required="required" class="form-control " name="pinet_id">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="pinet_tipe">Keterangan Paket Internet <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="pinet_tipe" required="required" class="form-control" name="pinet_tipe">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="pinet_harga">Harga Paket Internet <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="number" id="pinet_harga" name="pinet_harga" required="required" class="form-control">
                        </div>
                    </div>
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