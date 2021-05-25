@extends('layouts.master')

@section('title','Penyimpanan File')


@push('custom-css')
<link rel="stylesheet" href="{{ asset('template/bs4/style.css') }}">
@endpush


@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left"><h3>File Dokumen</h3></div>
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
              <h2>File Dokumen</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <p>File terenkripsi</p>
              
              <div class="card-box">
                <div class="row">
                    <div class="col-lg-6 col-xl-6">
                        <h4 class="header-title m-b-30">My Files</h4>
                    </div>
                </div>

                <div class="row">
                    @foreach ($files as $file)
                    <div class="col-lg-3 col-xl-2">
                        <div class="file-man-box"><a href="{{route('employee.drive.file.remove',[$file['filename']])}}" class="file-close"><i class="fa fa-times-circle"></i></a>
                            <div class="file-img-box"><img src="{{ asset('images/file_icons/'.pathinfo($file['filename'],PATHINFO_EXTENSION).'.svg') }}" alt="icon"></div>
                            <a href="{{route('employee.file.decrypt.download',[$file['filename']])}}" class="file-download"><i class="fa fa-download"></i></a>
                            {{-- <a href="{{route('employee.drive.file.download',[$file])}}" class="file-download"><i class="fa fa-download"></i></a> --}}
                            <div class="file-man-title">
                                <h5 class="mb-0 text-overflow">{{$file['filename']}}</h5>
                                <p class="mb-0"><small>{{$file['size']}} MB</small></p>
                            </div>
                        </div>
                    </div>    
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-3 col-xl-2">
                        <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                            <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/eps.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                            <div class="file-man-title">
                                <h5 class="mb-0 text-overflow">Epsfile.eps</h5>
                                <p class="mb-0"><small>568.8 kb</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="button" class="btn btn-outline-danger w-md waves-effect waves-light"><i class="mdi mdi-refresh"></i> Load More Files</button>
                </div>
            </div>

            </div>
          </div>
        </div>
    </div>
</div>

@endsection