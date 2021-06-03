<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="{{ route('employee.dashboard') }}" class="site_title"><i class="fa fa-paw"></i> <span>Sistem Kripto!</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="{{ asset('template/gentelella/images/img.jpg') }}" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Halo,</span>
        <h2>{{$user->u_username}}</h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>Umum</h3>
        <ul class="nav side-menu">
          <li><a href=" {{ route('employee.dashboard') }} "><i class="fa fa-home"></i> Halaman Awal </a></li>
          <li><a><i class="fa fa-edit"></i> Penyimpanan File <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('employee.drive') }}">Lihat File</a></li>
              <li><a href="form_advanced.html">Upload File</a></li>
            </ul>
          </li>
          <li><a><i class="fa fa-desktop"></i> Pengolahan File <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('employee.file.encrypt') }}">Enkripsi File</a></li>
              <li><a href="{{ route('employee.file.decrypt') }}">Dekripsi File</a></li>
              <li><a href="{{ route('employee.file.sign') }}">Tanda Tangan File</a></li>
              <li><a href="{{ route('employee.file.verify') }}">Verifikasi Tanda Tangan</a></li>
              <li><a href="glyphicons.html">Multi Pengamanan File</a></li>
            </ul>
          </li>
          <li><a><i class="fa fa-table"></i> Pengolahan Kunci <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="tables.html">Atur kunci saya</a></li>
            </ul>
          </li>
        </ul>
      </div>

      <div class="menu_section">
        <h3>Bantuan</h3>
        <ul class="nav side-menu">
          <li><a><i class="fa fa-bug"></i> Cara Penggunaan</a></li>
          <li><a><i class="fa fa-windows"></i> Help Desk</a></li>
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
    <!-- /menu footer buttons -->
  </div>
</div>