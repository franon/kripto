@extends('layouts.master')

@section('title','File Dekripsi')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left"><h3>Form Unggah</h3></div>
        <div class="title_right">
          <div class="col-md-5 col-sm-5   form-group pull-right top_search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
            </div>
          </div>
        </div>
    </div>
    
    <div class="clear-fix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12  ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Unggah File</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <p>Unggah File yang akan di dekripsi</p>
              @if (session('error'))
              <div class="alert alert-danger"> 
                    {{ session('error') }}
              </div>
              @endif
                <form action="{{route('employee.file.decrypt.upload')}}" method="post" enctype="multipart/form-data">
                    @csrf

                  <div class="form-group">
                      <label for="file"><h2>File</h2></label>
                      <input type="file" name="file" class="form-control-file" id="file"/>
                  </div>

                  <div class="form-group">
                      <label for="kunci"><b>Kunci</b></label>
                      <input type="text" name="kunci" class="form-control" id="kunci" minlength="32" maxlength="32"/>
                  </div>

                    <input type="submit" value="upload" class="btn btn-primary">
                </form>
              <br />
              <br />
              <br />
              <br />
            </div>
          </div>
        </div>
    </div>
</div>
@endsection