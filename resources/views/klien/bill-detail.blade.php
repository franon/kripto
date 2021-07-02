<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('template/lv/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('template/lv/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('template/lv/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('template/lv/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('template/lv/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('template/lv/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('template/lv/css/main.css') }}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ asset('template/lv/images/img-01.png') }}" alt="IMG">
				</div>

				<div class="login100-form">
					<div class="card text-center">
						<div class="card-header">
						  Tagihan 
						</div>
						<div class="card-body">
						  <h5 class="card-title">Periode @php
							  echo date('F Y');
						  @endphp</h5>
						  <ul class="list-group list-group-flush">
							<li class="list-group-item">ID Akun: {{$tagihan[0]->k_id}}</li>
							<li class="list-group-item">Nominal: Rp. {{number_format($tagihan[0]->tagihan_total,0,'.','.')}}</li>
						  </ul>
						</div>
						@if ($tagihan[0]->status_bayar == 0)
						<div class="card-footer text-white" style="background-color:#CD113B;">
							<strong> BELUM LUNAS </strong>
						</div>	
						@else
						<div class="card-footer text-white" style="background-color:#66DE93;">
							<strong> LUNAS </strong>
						</div>	
						@endif
						
					  </div>
				</div>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="{{ asset('template/lv/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('template/lv/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('template/lv/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('template/lv/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('template/lv/vendor/tilt/tilt.jquery.min.js') }}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('template/lv/js/main.js') }}"></script>

</body>
</html>