@extends('layouts.master')

@section('title','Unggah File Enkripsi')

@push('custom-css')
    <style>
      .dropzoneDragArea {
        background-color: #fbfdff;
        border: 1px dashed #c0ccda;
        border-radius: 6px;
        padding: 60px;
        text-align: center;
        margin-bottom: 15px;
        cursor: pointer;
      }

      .dropzone{
        box-shadow: 0px 2px 20px 0x #f2f2f2;
        border-radius: 10px;
      }
    </style>
@endpush

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
                <form id="encrypt-file" action="{{route('employee.file.encrypt.upload')}}" method="post" enctype="multipart/form-data">
                    @csrf

                  <div class="form-group">
                      <label for="kunci"><b>Kunci</b></label>
                      <input type="text" name="kunci" class="form-control" id="kunci" minlength="32" maxlength="32"/>
                  </div>

                    {{-- <div class="form-group"> --}}
                      {{-- <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea"> --}}
                        {{-- <label for="file"><h2>File</h2></label> --}}
                        {{-- <span> Upload File </span> --}}
                        {{-- <input type="file" name="file" class="form-control-file" id="file"/> --}}
                      {{-- </div> --}}
                      {{-- <div class="dropzone-previews"></div> --}}
                    {{-- </div> --}}

                    <div class="form-group">
                      <div class="dropzone" id="myDropzone"></div>
                    </div>

                    <div class="form-group">
                      <button type="submit" id="submit-all" value="submit" class="btn btn-primary">Enkrip</button>
                    </div>
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

{{-- @push('custom-js')
    <script type="text/javascript">
      Dropzone.autoDiscover = false;
      $(function(){
        var myDropzone= new Dropzone("div#myDropzone",{
        paramName: "file",
        url: "{{route('employee.file.encrypt.upload')}}",
        addRemoveLinks: true,
        autoProcessQueue: false,
        uploadMultiple: false,
        parallelUplaods: 1,
        maxFiles: 5,
        params: {
            _token: '{{csrf_token()}}'
        },
        maxFilesize: 10, 
        init: function(){
          var myDropzone = this;
          this.on('sending', function(file, xhr, formData){
          });

          this.on('success', function(file, response){

          });

          this.on('queuecomplete',function(){

          });

          this.on('sendingmultiple', function(){

          });

          this.on('successmultiple', function(files,response){

          });
          
          this.on('errormultiple', function(files,response){
            
          });
        }
        });

      });
    </script>
@endpush --}}

@push('custom-js')
<script type="text/javascript">
// Dropzone.autoDiscover = false;
// window.Dropzone.autoDiscover = false;
// var token = $('meta[name="csrf-token"]').attr("content");
  Dropzone.options.myDropzone= {
    url: "{{ route('employee.file.encrypt.upload') }}",
    // dictDefaultMessage: 'Drop Here!',
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 5,
    maxFiles: 5,
    maxFilesize: 10,
    // acceptedFiles: 'image/*',
    addRemoveLinks: true,
    // autoDiscover: false,
    // paramName: "file[]",
    params: {
            _token: '{{csrf_token()}}'
        },
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    init: function() {
        var dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

        // for Dropzone to process the queue (instead of default form behavior):
        document.getElementById("submit-all").addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            dzClosure.processQueue();
        });
        //send all the form data along with the files:
        this.on("sendingmultiple", function(file,xhr,formData) {
          formData.append("kunci", jQuery("#kunci").val());
          // console.log(file);
          // console.log(xhr);
          // console.log(formData);
        });

        this.on('successmultiple', function(files, response){
          // console.log(files);
          // console.log(response);
          window.location = "{{route('employee.drive')}}";
        });

        this.on("errormultiple", function(files, response) {
          console.log('error');
          // console.log(files);
          // console.log(response);
        });
    }
}
</script>
    
@endpush