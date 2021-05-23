<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="icon" href="images/favicon.ico" type="image/ico" />
    <title>@yield('title')</title>
    @include('includes.employee.head')
    @stack('custom-css')

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        
        @include('includes.employee.side-menu')
        @include('includes.employee.top-navigation')

        <!-- page content -->
        <div class="right_col" role="main">
          
            {{-- @include('includes.employee.content-default') --}}

            @yield('content')

        </div>
        <!-- /page content -->


        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    @include('includes.employee.footer')
    @stack('custom-js')
  </body>
</html>
