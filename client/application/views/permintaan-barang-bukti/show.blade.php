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
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="table-petugas" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>No Permintaan</th>
                  <th>Jumlah Barang Bukti</th>
                  <th>Status</th>                  
                  <th>Waktu Permintaan</th>
                  <th width="20%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($data_permintaan_bb as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->id_permintaan_bb }} / GB-02 / GOBANG / {{ numberToRomawi(date('m')) }} / {{ date('Y') }}</td>
                            <td>{{ $item->total_permintaan }} Barang Bukti</td>                            
                            <td>
                                {{ $item->acc_kejaksaan == 0 ? "Menunggu Konfirmasi" : "Di Terima" }}
                            </td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <button                                   
                                    data-id_permintaan_bb = "{{ $item->id_permintaan_bb }}"
                                    data-toggle="modal"                                     
                                    type="button" 
                                    class="btnLihatDetail btn btn-primary ">Lihat Detail
                                </button>          
                                <button 
                                    {{ $item->acc_kejaksaan == 1 ? "disabled" : "" }}
                                    data-nomer_permintaan = "{{ $item->id_permintaan_bb }}"
                                    data-total_permintaan = "{{ $item->total_permintaan }}"
                                    data-toggle="modal" 
                                    data-target="#modal-terima" 
                                    type="button" 
                                    class="konfirmasiBarangBukti btn btn-success ">Konfirmasi
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

      <div class="modal fade" id="modal-terima">
        <div class="modal-dialog">
          <div class="modal-content"> 
            <form action="{{ base_url('permintaan-barang-bukti/konfirmasi-barang-bukti') }}" method="post">             
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><b>Konfirmasi Penyerahan Barang Bukti</b></h4>
              </div>              
              <div class="modal-body">                          
                  <span id="title_modal_terima"></span>                 
              </div>
              <div class="modal-footer">
                <input type="submit" name="submit" value="Konfirmasi" class="btn btn-success">
                <input type="hidden" name="nomor_permintaan" id="#nomorPermintaanSlur">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
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

  $(".btnLihatDetail").click(function(){
    let id      = $(this).data('id_permintaan_bb');    
    window.location = "{{ base_url('permintaan-barang-bukti/download-detail-permintaan-barang-bukti/') }}" + id;
  });

  $(".konfirmasiBarangBukti").click(function(){
        let nomer_permintaan      = $(this).data('nomer_permintaan');
        let total_permintaan      = $(this).data('total_permintaan');
        $('input[name="nomor_permintaan"]').val(nomer_permintaan);
        
        // INI BELUM BENAR =======================================================================================================
        $("#title_modal_terima").text("Konfirmasi pengambilan barang bukti dengan nomor permintaan " + nomer_permintaan + 
        " / GB-02 / GOBANG / I / 2020 ? Dengan mengeklik tombol konfirmasi di bawah ini, maka status tanggung jawab barang bukti akan berpindah ke PT POS Indonesia");
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