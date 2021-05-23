<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>File Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
    <div class="row">
        <div class="container">

            <h2 class="text-center my-5">Upload File</h2>

            <div class="col-lg-8 mx-auto my-5">
                @if (count($errors)>0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }} <br/>
                        @endforeach
                    </div>
                @endif

                <form action="/upload/process" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <b>File</b>
                        <input type="file" name="file">
                    </div>

                    <div class="form-group">
                        <b>Keterangan</b>
                        <textarea name="keterangan" class="form-control" cols="30" rows="10"></textarea>
                    </div>

                    <input type="submit" value="upload" class="btn btn-primary">
                </form>
            </div>
            
        </div>
    </div>
</body>
</html>