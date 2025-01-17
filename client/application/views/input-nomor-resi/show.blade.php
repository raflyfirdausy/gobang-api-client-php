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
            <div class="box-body table-responsive">
              <table id="table-petugas" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>No Reg Tilang</th>
                    <th>Nama Penerima</th>
                    <th>Alamat Tujuan Antar</th> 
                    <th>Nomor Hp</th>                                   
                    <th>Aksi</th>
                    </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-input">
        <div class="modal-dialog">
          <div class="modal-content"> 
            <form action="{{ base_url('input-nomor-resi/proses') }}" method="post">             
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><b><span id="modalTitleSlur" ></span></b></h4>                  
              </div>              
              <div class="modal-body">                          
                <div class="form-group">
                    <label class="form-label">No Resi</label>
                    <input type="text" name="no_resi" class="form-control">  
                    <input type="hidden" name="id_bb_status" id="idBBStatusSlur">
                </div>          
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <input type="submit" name="submit" value="Input" class="btn btn-primary">                
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

    $(document).ready(function() {
        get_data();
    });

    function get_data(){
        $('#table-petugas').DataTable({
            "bProcessing"   : true,            
            "ajax"          : {
                "url"       : "{{ base_url('input-nomor-resi/get-data') }}",
                "type"      : "GET",
                "error"     : function(){
                    alert("Terjadi kesalahan saat mengambil data");
                },
                "dataSrc"   : function(json){
                    var return_data = new Array();
                    for(var i = 0;  i< json.length; i++){
                        return_data.push({
                            "no"            : (i + 1),
                            "no_reg_tilang" : json[i].no_reg_tilang,
                            "nama_penerima" : json[i].nama_penerima,
                            "alamat_antar"  : json[i].detail_alamat + ", " + json[i].alamat_antar + " " + json[i].kode_pos,
                            "nomer_hp"      : json[i].nomer_hp,
                            "btn_input"     : "<button onclick='yuhu(\""+ json[i].id_bb_status +"\",\""+ json[i].no_reg_tilang +"\")' class='inputResi btn btn-primary' data-toggle='modal' data-target='#modal-input' data-id_bb_status = '" + json[i].id_bb_status +"' data-no_reg_tilang = '" + json[i].no_reg_tilang +"' >Input No Resi </button>"
                        })
                    }
                    return return_data;
                }
            },
            "columns"       : [
                { "data"    : "no" },
                { "data"    : "no_reg_tilang" },
                { "data"    : "nama_penerima" },
                { "data"    : "alamat_antar" },
                { "data"    : "nomer_hp" },
                { "data"    : "btn_input" }
            ]
        });
    }

    function yuhu(id_bb_status, no_reg_tilang){            
        $("#modalTitleSlur").text("Input Nomor Resi  ( No Reg Tilang : " + no_reg_tilang + " )");
        $("#idBBStatusSlur").val(id_bb_status);
    }

  $(".konfirmasiBarangBukti").click(function(){
        let nomer_permintaan      = $(this).data('nomer_permintaan');
        let total_permintaan      = $(this).data('total_permintaan');
        $('input[name="nomor_permintaan"]').val(nomer_permintaan);
        $("#title_modal_terima").text("Konfirmasi pengambilan barang bukti dengan nomor permintaan " + nomer_permintaan + 
        " ? Dengan mengeklik tombol konfirmasi di bawah ini, maka status tanggung jawab barang bukti akan berpindah ke PT POS Indonesia");
    });

    $(function () {
        

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