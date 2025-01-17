<header class="main-header">
      <a href="#" class="logo">
        <span class="logo-mini"><b>GB</b></span>
        <span class="logo-lg"><b>GO </b>BANG</span>
      </a>
      <nav class="navbar navbar-static-top skin-green">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
  
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ $user_data->nama }}</span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">  
                  <p>
                    {{ $user_data->nama }}
                    <small>
                        @php
                          if($user_data->level == "super_admin"){
                            echo "Kepala Kejaksaan";
                            } else if ($user_data->level == "admin"){
                              echo "Admin Kejaksaan";
                            } else if ($user_data->level == "pgm"){
                              echo "POS Giro Mobile";
                            } else if ($user_data->level == "pos"){
                              echo "Kantor Pos";
                            } else {
                              echo "Tidak Diketahui";
                            }
                        @endphp
                    </small>
                  {{-- <small>Terakhir Login : {{ date("d M Y | H:i:s", strtotime($user_data->last_login)) }} WIB</small> --}}
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  {{-- <div class="pull-left">
                    <a href="{{ base_url('profile') }}" class="btn btn-default btn-flat">Profile</a>
                  </div> --}}
                  <div class="pull-right">
                    <a href="{{ base_url('logout') }}" class="btn btn-default btn-flat">Keluar</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>