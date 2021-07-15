<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      {{-- <a href="{{ route('employee.dashboard') }}" class="site_title"><i class="fa fa-paw"></i> <span>GMDP</span></a> --}}
      <a href="{{ route('employee.dashboard') }}" class="site_title"><img src="{{asset('images/gmdp_logo.png')}}" alt="" width="30" height="30"> <span>GMDP</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="{{ asset('template/gentelella/images/img.jpg') }}" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Halo,</span>
        <h2>{{$user->p_namalengkap}}</h2>
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
          <li><a><i class="fa fa-hdd-o" ></i> Penyimpanan File <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('employee.drive') }}">Lihat File</a></li>
              <li><a href="{{ route('employee.drive.personal') }}">Lihat File Saya</a></li>
              <li><a href="form_advanced.html">Upload File</a></li>
            </ul>
          </li>
          <li><a><i class="fa fa-shield"></i> Pengolahan File <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('employee.file.encrypt') }}">Enkripsi File</a></li>
              <li><a href="{{ route('employee.file.decrypt') }}">Dekripsi File</a></li>
              <li><a href="{{ route('employee.file.encrypt.multi') }}">Enkripsi Multi File</a></li>
              {{-- <li><a href="{{ route('employee.file.sign') }}">Tanda Tangan File</a></li>
              <li><a href="{{ route('employee.file.verify') }}">Verifikasi Tanda Tangan</a></li>
              <li><a href="{{ route('employee.file.multisec') }}">Multi Pengamanan File</a></li> --}}
            </ul>
          </li>
          {{-- <li><a><i class="fa fa-table"></i> Tagihan <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('employee.daftar.klien') }}">Daftar Pelanggan</a></li>
              <li><a href="{{ route('employee.daftar.klien.tagihan') }}">Tagihan Pelanggan</a></li>
            </ul>
          </li> --}}
          {{-- <li><a><i class="fa fa-key"></i> Pengolahan Kunci <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="tables.html">Atur kunci saya</a></li>
            </ul>
          </li> --}}
          <li><a><i class="fa fa-user-secret" aria-hidden="true"></i> Internal <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('employee.internal.paket_internet') }}">Daftar Paket</a></li>
              <li><a href="{{ route('employee.internal.direktori') }}">Daftar Folder</a></li>
            </ul>
          </li>
        </ul>
      </div>

      <div class="menu_section">
        <h3>Bantuan</h3>
        <ul class="nav side-menu">
          <li><a><i class="fa fa-info-circle"></i> Cara Penggunaan</a></li>
          <li><a><i class="fa fa-phone-square"></i> Help Desk</a></li>
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