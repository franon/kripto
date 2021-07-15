@extends('layouts.master')

@section('title','Penyimpanan File Pribadi')


@push('custom-css')
<link rel="stylesheet" href="{{ asset('template/bs4/style.css') }}">
@endpush


@section('content')
<div class="col-md-12 col-sm-12  ">
  <div class="x_panel">
    <div class="x_title">
      <h2 class="text-justify">File Dokumen</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <p>File Saya</p>
      
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
                <div class="file-man-box">
                  @if ($user->p_namapengguna == $file->pembuat)
                  <a href="{{route('employee.drive.file.remove',[base64_encode($file->file_jalurutuh)])}}" class="file-close"><i class="fa fa-times-circle"></i></a>
                  @endif
                    <div class="file-img-box"><img src="{{ asset('images/file_icons/'.pathinfo($file->file_nama,PATHINFO_EXTENSION).'.svg') }}" alt="icon"></div>
                    {{-- <a href="{{route('employee.file.decrypt.download',[$file->file_nama])}}" class="file-download"><i class="fa fa-download"></i></a> --}}
                    <a href="{{route('employee.drive.file.download',[base64_encode($file->file_jalur)])}}" class="file-download"><i class="fa fa-download"></i></a>
                    @if ($penentu === "encrypted")
                    <a href="#decryptFile" class="file-unlock" data-toggle="modal" data-target="#decryptFile" data-file="{{$file->file_jalur}}"><i class="fa fa-unlock"></i></a>  
                    @endif
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
@endsection