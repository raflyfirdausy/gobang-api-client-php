  <aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ $user_data->nama }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> 
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
            </a>
          </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">
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
          </li>
          {{-- <li class="{{ $aktif == 'profile_pgm' ? 'active' : '' }}">
            <a href="{{ base_url('profile-pgm') }}"><i class="fa fa-fire"></i> <span>Profile PGM</span></a>
          </li> --}}
          @if ($user_data->level != "pos")
            <li class="{{ $aktif == 'dashboard' ? 'active' : '' }}">
              <a href="{{ base_url('dashboard') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a>
            </li>
          @endif
          
          @if ($user_data->level == 'super_admin')            
          <li class="treeview {{ $aktif == 'petugas' ? 'active' : '' }}">
            <a href="#">
              <i class="fa fa-user-plus"></i> <span>Petugas</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class=""><a href="{{ base_url('kejaksaan') }}"><i class="fa fa-circle-o"></i> Admin Kejaksaan</a></li>
              <li><a href="{{ base_url('pos') }}"><i class="fa fa-circle-o"></i> Admin POS</a></li>
              {{-- <li><a href="{{ base_url('kurir') }}"><i class="fa fa-circle-o"></i> Petugas Kurir</a></li> --}}
            </ul>
          </li>  
          @endif
          @if ($user_data->level == 'super_admin' || $user_data->level == 'admin')
            <li class="{{ $aktif == 'data_tilang' ? 'active' : '' }}">
              <a href="{{ base_url('data-tilang/') }}"><i class="fa fa-laptop"></i> <span>Data Tilang</span></a>
            </li>      
            <li class="{{ $aktif == 'riwayat_permintaan_user' ? 'active' : '' }}">
              <a href="{{ base_url('riwayat-permintaan-user') }}">
                <i class="fa fa-bell-o"></i> <span>Riwayat Permintaan User</span>              
              </a>
            </li>    
            <li class="{{ $aktif == 'permintaan_barang_bukti' ? 'active' : '' }}">
                <a href="{{ base_url('permintaan-barang-bukti') }}"><i class="fa fa-laptop"></i> <span>Permintaan Barang Bukti</span></a>
            </li>
          @endif                   
          @if ($user_data->level == 'pos')
            <li class="{{ $aktif == 'daftar_permintaan_user' ? 'active' : '' }}">
              <a href="{{ base_url('daftar-permintaan-user') }}">
                <i class="fa fa-check-square-o"></i> <span>Daftar Permintaan User</span>
                @if ($g_permintaan_bb > 0)
                  <span class="pull-right-container">
                    <small class="label pull-right bg-blue">{{{ $g_permintaan_bb }}}</small>
                  </span>
                @endif              
              </a>
            </li>   
            
            <li class="{{ $aktif == 'riwayat' ? 'active' : '' }}">
                <a href="{{ base_url('riwayat-pengambilan-barang-bukti') }}"><i class="fa fa-bell-o"></i> <span>Riwayat Pengambilan BB</span></a>
            </li>  
            <li class="{{ $aktif == 'input_resi' ? 'active' : '' }}">
                <a href="{{ base_url('input-nomor-resi') }}"><i class="fa fa-check-square-o"></i> <span>Input Nomor Resi</span></a>
            </li>  
          @endif          
        </ul>
      </section>
    </aside>