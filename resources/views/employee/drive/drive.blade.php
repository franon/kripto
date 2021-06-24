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
              <h2 class="text-justify">File Dokumen</h2>
              <!-- Unggah file -->
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-upload" aria-hidden="true"></i>
                  unggah
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('employee.file.encrypt') }}">Enkripsi File</a>
                  <a class="dropdown-item" href="{{ route('employee.file.sign') }}">Tanda Tangan File</a>
                </div>
              </div>
              |
              <!-- Buat Folder -->
              <div class="btn-group">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#createFolder"> <i class="fa fa-plus" aria-hidden="true"></i>Buat Folder</button>
              </div>

              <!-- Modal -->
              <div class="modal fade" id="createFolder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Buat Folder</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{ route('employee.internal.direktori.tambah.proses') }}">
                        @csrf
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="dir_nama">Nama Folder <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="dir_nama" required="required" class="form-control" name="dir_nama">
                            </div>
                        </div>
                        <div class="item form-group">
                          @php $direktori = explode('/',url()->current());
                          $direktori = base64_decode(end($direktori));
                          @endphp
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="dir_parent">Parent Folder <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="dir_parent" class="form-control" name="dir_parent" value="{{$direktori}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                      <button type="submit" class="btn btn-success" name="submit">Buat Folder</button>
                    </div>
                  </div>
                </div>
              </div>

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
                {{-- @dd($directory) --}}
                <div class="row">
                  @isset($directory)
                    @foreach ($directory as $dir)
                    <div class="col-lg-3 col-xl-2">
                      <div class="file-man-box">
                          <div class="file-img-box">
                            <a href="{{route('employee.drive.directory',['directory'=> base64_encode($dir->dir_jalur)])}}"><img src="{{asset('images/file_icons/folder.svg')}}" alt="icon"></a></div>
                          <div class="file-man-title">
                            {{-- @if (is_array(explode('/',$dir)))
                            @php $folderName = explode('/',$dir); $folderName = end($folderName); @endphp
                              <h5 class="mb-0 text-overflow">Folder {{ $folderName }}</h5>
                            @endif --}}
                              <h5 class="mb-0 text-overflow">Folder {{$dir->dir_nama}}</h5>
                          </div>
                      </div>
                    </div>
                    @endforeach  
                  @endisset
                  
                  @isset($files)
                  @foreach ($files as $file)
                  @php $penentu = explode('/',$file->file_jalur)[0]; @endphp
                    <div class="col-lg-3 col-xl-2">
                        <div class="file-man-box"><a href="{{route('employee.drive.file.remove',[base64_encode($file->file_jalurutuh)])}}" class="file-close"><i class="fa fa-times-circle"></i></a>
                            <div class="file-img-box"><img src="{{ asset('images/file_icons/'.pathinfo($file->file_nama,PATHINFO_EXTENSION).'.svg') }}" alt="icon"></div>
                            {{-- <a href="{{route('employee.file.decrypt.download',[$file->file_nama])}}" class="file-download"><i class="fa fa-download"></i></a> --}}
                            <a href="{{route('employee.drive.file.download',[$penentu,base64_encode($file->file_jalur.$file->file_nama)])}}" class="file-download"><i class="fa fa-download"></i></a>
                            <div class="file-man-title">
                              @if (empty($file->file_alias))
                              <h5 class="mb-0 text-overflow">{{$file->file_nama}}</h5>
                              @endif
                                <h5 class="mb-0 text-overflow">{{$file->file_alias}}</h5>
                                <p class="mb-0"><small>{{round($file->file_ukuran/1000000,2)}} MB</small></p>
                            </div>
                        </div>
                    </div>    
                    @endforeach
                  @endisset
                  
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