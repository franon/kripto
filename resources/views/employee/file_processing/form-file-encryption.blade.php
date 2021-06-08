@extends('layouts.master')

@section('title','Unggah File Enkripsi')

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
              <p>Unggah File yang akan di enkripsi</p>
              @if (count($errors)>0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }} <br/>
                        @endforeach
                    </div>
                @endif
              
                <form action="{{route('employee.file.encrypt.upload')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <b>File</b>
                        <input type="file" name="file">
                    </div>

                    <div class="form-group">
                        <b>Kunci</b>
                        <textarea name="key" class="form-control" cols="15" rows="2"></textarea>
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