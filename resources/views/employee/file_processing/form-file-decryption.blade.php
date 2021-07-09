@extends('layouts.master')

@section('title','File Dekripsi')

@section('content')
<div class="col-md-12 col-sm-12  ">
  <div class="x_panel">
    <div class="x_title">
      <h2 style="float: left;"><b>Unggah File</b></h2>
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
@endsection