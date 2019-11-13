@extends('layout.admin')

@section('tab-title')
    {{ $title }}
@endsection

@section('page-title')
{{ $title }}
@endsection

@section('page-header')

@endsection

@section('page-breadcrumb')
<li><a href="{{ base_url('dashboard') }}"><i class="fa fa-home"></i> {{ $app_name }}</a></li>
<li class="active">{{ $title }}</li>
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
            <div class="box-header">                
                <div class="col-md-12">
                    <div class="form-group pull-right">
                        <div class="input-group">
                            <button type="button" class="btn btn-primary pull-right" id="daterange-btn">
                            <span>
                                <i class="fa fa-calendar"></i> Filter Tanggal
                            </span>
                                <i class="fa fa-caret-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="table-petugas" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>No Reg Tilang</th>
                  <th>Nama Terpidana</th>
                  <th>Alamat Antar</th>                  
                  <th>Nomer Hp</th>                  
                  <th>Total Biaya (Rp)</th>
                  <th>Waktu Permintaan</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data_permintaan as $item)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->no_reg_tilang }}</td>
                      <td>{{ $item->nama_terpidana }}</td>
                      <td>{{ $item->alamat_antar }}</td>
                      <td>{{ $item->nomer_hp }}</td>
                      <td>{{ $item->total_biaya }}</td>
                      <td>{{ $item->waktu_permintaan }}</td>
                      <td>{{ $item->status_riwayat }}</td>
                      <td>
                          <button 
                            data-id_permintaan  = "{{ $item->id_permintaan }}"                             
                            data-toggle="modal" 
                            data-target="#modal-detail" 
                            type="button" 
                            class="detailData btn btn-danger col-xs-12">Detail
                          </button>
                        </td>
                  </tr>                      
                  @endforeach                    
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-detail">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Detail Data Permintaan User</b></h4>
              </div>              
                  <div class="modal-body">  
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">No Reg Tilang</label>
                                <input readonly value="Loading..." type="text" id="m_no_reg_tilang" name="m_no_reg_tilang" class="form-control">  
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nama terpidana</label>
                                <input readonly value="Loading..." type="text" id="m_nama_terpidana" name="m_nama_terpidana" class="form-control">  
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Alamat Terpidana</label>
                                <input readonly value="Loading..." type="text" id="m_alamat_terpidana" name="m_alamat_terpidana" class="form-control">  
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Total Biaya (Termasuk admin dan ongkir)</label>
                                <input readonly value="Loading..." type="text" id="m_denda_plus_perkara" name="m_denda_plus_perkara" class="form-control">  
                            </div>
                        </div>
                      </div>                            
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nama Penerima</label>
                                <input readonly value="Loading..." type="text" id="m_nama_penerima" name="m_alamat_penerima" class="form-control">  
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">No Hp Penerima</label>
                                <input readonly value="Loading..." type="text" id="m_no_hp" name="m_no_hp" class="form-control">  
                            </div>
                        </div>
                      </div> 
                      <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Alamat Penerima</label>
                                <input readonly value="Loading..." type="text" id="m_alamat_penerima" name="m_alamat_penerima" class="form-control">  
                            </div>
                        </div>                        
                      </div> 
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="form-label">Nomor VA</label>
                                  <input readonly value="Loading..." type="text" id="m_nomor_va" name="m_nomor_va" class="form-control">  
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="form-label">Posisi Barang Bukti</label>
                                  <input readonly value="Loading..." type="text" id="m_posisi" name="m_posisi" class="form-control">  
                              </div>
                          </div>
                        </div> 
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>                      
                  </div>              
            </div>
          </div>
      </div>


      <div class="modal fade" id="modal-import">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Import Data Tilang</h4>
            </div>
            <form enctype="multipart/form-data" role="form" method="POST" action="{{ base_url('data-tilang/import-tilang') }}">
              <div class="modal-body">
                  Sebelum upload file excel data tilang, pastikan formatnya sudah sesuai. Silahkan download contoh format excel data tilang
                  <b><a href="{{ asset('template/format-import-data-tilang.xlsx') }}"> DI SINI </a></b>
                  <br><br>
                
                  <div class="form-group">
                    <label for="">Pilih file Excel Data tilang</label>
                    <label for="exampleInputFile"></label>
                    <input required class="form-control pull-right" name="file_excel" type="file" accept=".xls,.xlsx" id="inputExcel">
                    <p class="help-block">Tipe File : .xls / .xlsx</p>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
              </div>
            </form>
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
        let id_permintaan      = $(this).data('id_permintaan');           
        $.ajax({
          type: 'GET',
          url: '{{ base_url("riwayat-permintaan-user/ajax_get_data_permintaan/") }}' + id_permintaan,
          dataType: 'json',
          success: function(x){
              if(x.status == 1){
                  $("#m_no_reg_tilang").val(x.data.no_reg_tilang);
                  $("#m_nama_terpidana").val(x.data.nama_terpidana);
                  $("#m_nama_penerima").val(x.data.nama_penerima);
                  $("#m_alamat_terpidana").val(x.data.alamat_terpidana);
                  $("#m_denda_plus_perkara").val(parseInt(x.data.nominal_denda) + parseInt(x.data.nominal_perkara) + parseInt(x.data.nominal_pos) + parseInt(x.data.nominal_gobang));
                  $("#m_nama_penerima").val(x.data.nama_penerima);
                  $("#m_no_hp").val(x.data.nomer_hp);
                  $("#m_alamat_penerima").val(x.data.detail_alamat + ", " + x.data.alamat_antar);
                  $("#m_nomor_va").val(x.data.no_va);
                  $("#m_posisi").val(x.data.posisi);                  
              } else {
                  alert("Terjadi kesalahan pada server");
              }
          }
      });
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