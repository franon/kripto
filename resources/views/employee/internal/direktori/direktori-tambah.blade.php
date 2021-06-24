@extends('layouts.master')

@section('title','Tambah Folder')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title" >
                <h2>Folder</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{ route('employee.internal.direktori.tambah.proses') }}">
                    @csrf

                    {{-- <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="dir_id">ID Folder <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="dir_id" required="required" class="form-control " name="dir_id">
                        </div>
                    </div> --}}
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="dir_nama">Nama Folder <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="dir_nama" required="required" class="form-control" name="dir_nama">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="dir_jalur">Path Folder <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="dir_jalur" required="required" class="form-control" name="dir_jalur">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="dir_parent">Parent Folder <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="dir_parent" class="form-control" name="dir_parent">
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