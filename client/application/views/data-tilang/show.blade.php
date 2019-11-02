@extends('layout.admin')

@section('tab-title')
    Data Tilang
@endsection

@section('page-title')
Data Tilang
@endsection

@section('page-header')


@endsection

@section('page-breadcrumb')
<li><a href="{{ base_url('dashboard') }}"><i class="fa fa-dashboard"></i> GO BANG</a></li>
<li class="active">Data Tilang</li>
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
                <div class="col-md-4 no-padding">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-import">
                    Import Data Tilang
                  </button>
                </div>
                <div class="col-md-8">
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
                  <th>Alamat</th>                  
                  <th>Total Denda</th>
                  <th>Posisi Barang Bukti</th>
                  <th>Request Antar</th>
                  <th>Waktu Input</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($dataTilang as $item)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->no_reg_tilang }}</td>
                      <td>{{ $item->nama_terpidana }}</td>
                      <td>{{ $item->alamat_terpidana }}</td>                
                      <td>{{ (int) $item->denda + (int) $item->biaya_perkara }}</td>
                      <td>{{ $item->posisi }}</td>
                      <td>TIDAK</td>
                      <td>{{ $item->created_at }}</td>
                      <td>

                          <a href="#" type="button" class="btn col-md-12 btn-primary btn-sm">Detail</a>
                          {{-- <a href="#" type="button" class="btn btn-flat btn-warning btn-sm">UBAH</a> --}}              
                          
                          <button 
                          data-no_reg_tilang  ="{{ $item->no_reg_tilang }}" 
                          data-nama_terpidana ="{{ $item->nama_terpidana }}" 
                          data-toggle="modal" 
                          data-target="#modal-hapus" 
                          type="button" 
                          class="hapusData btn btn-danger col-xs-12">Hapus</button>
                      </td>
                  </tr>
                  @endforeach                   
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-hapus">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Peringatan Hapus Data</b></h4>
              </div>
              <form enctype="multipart/form-data" role="form" method="POST" action="{{ base_url('data-tilang/hapus-tilang') }}">
                  <div class="modal-body">  
                      <b>Peringatan!</b> 
                      <span id="info_hapus">Kamu akan menghapus data Rafli Firdausy</span> <br>
                      <span>Data yang di hapus tidak dapat di kembalikan. Tetap hapus ?</span>
                      <input type="hidden" name="no_reg_tilang" id="NoRegTilang">
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                      <input type="submit" name="submit" value="Hapus" class="btn btn-danger">
                  </div>
              </form>
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