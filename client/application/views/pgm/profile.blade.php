@extends('layout.admin')

@section('tab-title')
    Profile POS Giro Mobile
@endsection

@section('page-title')
Profile POS Giro Mobile
@endsection

@section('page-header')


@endsection

@section('page-breadcrumb')
<li><a href="{{ base_url('dashboard') }}"><i class="fa fa-dashboard"></i> GO BANG</a></li>
<li class="active">Profile POS Giro Mobile</li>
@endsection


@section('page-content')
    <div class="row">        
        <div class="col-xs-12">

            @if ($CI->session->flashdata("sukses"))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Sukses</h4>
                {{ $CI->session->flashdata("sukses") }}
            </div>
            @endif      
            
            @if ($CI->session->flashdata("gagal"))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Gagal</h4>
                @php
                    if(is_array($CI->session->flashdata("gagal"))){
                      $dataAlasan = NULL;
                      foreach ($CI->session->flashdata("gagal") as $item) {                        
                       $dataAlasan .= "Gagal Insert data nomor " . $item["no"] . " Karena " . $item["alasan"] . "<br>";
                      }
                      echo $dataAlasan;
                    } else {
                      echo $CI->session->flashdata("gagal");
                    }
                @endphp

            </div>
            @endif

          <div class="box box-success">
            <div class="box-body">
                <div class="col-md-6">
                    <h3>Profile & API Credentials</h3>
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="name" class="control-label">Nama</label>
                            <input class="form-control" name="nama" type="text" id="nama">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input class="form-control" name="email" type="email" id="email">
                        </div>
                        <div class="form-group">
                            <label for="screet_key" class="control-label">Screet Key</label>
                            <div class="input-group">
                                <input class="form-control" name="screet_key" type="text" id="screet_key">
                                <div class="input-group-btn">                                  
                                  <button data-toggle="tooltip" title="Copy Screet Key" type="button" class="btn btn-success"> <i class="fa fa-copy"></i></button>
                                  <button data-toggle="tooltip" title="Regenerate Screet Key" type="button" class="btn btn-danger"> <i class="fa fa-refresh"></i></button>
                                </div>                                
                              </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h3>Password</h3>
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="name" class="control-label">Password saat ini</label>
                            <input class="form-control" name="current_pass" type="password" id="current_pass">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Password baru</label>
                            <input class="form-control" name="password_baru" type="password" id="password_baru">
                        </div>
                        <div class="form-group">
                            <label for="screet_key" class="control-label">Ulangi password baru</label>
                            <input class="form-control" name="ulangi_password_baru" type="password" id="ulangi_password_baru">                                                                                    
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-footer')
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src=" {{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src=" {{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script>

  $(".detailData").click(function(){
      let no_reg_tilang = $(this).data('no_reg_tilang');
      $.ajax({
          type: 'GET',
          url: '{{ base_url("api/get_daftar_terpidana/") }}' + no_reg_tilang,
          dataType: 'json',
          success: function(x){
              if(x.respon_code == 1){
                  $("#m_no_reg_tilang").val(x.data.no_reg_tilang);
                  $("#m_nama_terpidana").val(x.data.nama_terpidana);
                  $("#m_alamat_terpidana").val(x.data.alamat_terpidana);
                  $("#m_nomor_briva").val(x.data.nomor_briva);
                  $("#m_tanggal_penitipan").val(x.data.tgl_penitipan);
                  $("#m_jumlah_penitipan").val(x.data.jumlah_penitipan);
                  $("#m_tanggal_putusan").val(x.data.tgl_putusan);
                  $("#m_denda").val(x.data.denda);
                  $("#m_biaya_perkara").val(x.data.biaya_perkara);
                  $("#m_posisi").val(x.data.posisi);
              } else {
                  alert(x.respon_mess);
              }
          }
      });
  });

  $(".hapusData").click(function(){
        let no_reg_tilang      = $(this).data('no_reg_tilang');
        let nama_terpidana     = $(this).data('nama_terpidana');
    
        $("#info_hapus").text("Kamu akan menghapus data " + nama_terpidana + " dengan No Registrasi Tilang " + no_reg_tilang);
        $("#NoRegTilang").val(no_reg_tilang);
    });

    $(function () {
        $('#table-petugas').DataTable()

        $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          // 'Semua'           : [moment().subtract(9999, 'days'), moment()],
          'Hari Ini'        : [moment(), moment()],
          'Kemarin'         : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          '7 Hari Terakhir' : [moment().subtract(6, 'days'), moment()],
          '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
          'Bulan Ini'       : [moment().startOf('month'), moment().endOf('month')],
          'Bulan Kemarin'   : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment()
      },
      function (start, end) {        
        $('#daterange-btn span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));                
        window.location.href = "{{ base_url('data-tilang/index/') }}" + start.format('DD-MM-YYYY') + '/' + end.format('DD-MM-YYYY');
      }
    )
    })
</script>
@endsection