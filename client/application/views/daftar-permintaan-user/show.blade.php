@extends('layout.admin')

@section('tab-title')
    {{ $title }}
@endsection

@section('page-title')
{{ $title }}
@endsection

@section('page-header')
<link rel="stylesheet" href="{{ asset('css/select.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/dataTables.checkboxes.css') }}">
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
                            <button                             
                                {{ $data_permintaan["total_permintaan"] == 0 ? "disabled" : "" }}
                                data-jumlah = "{{ $data_permintaan["total_permintaan"] }}"
                                data-toggle="modal" 
                                data-target="#modal-berita-acara" 
                                type="button" 
                                id="btn_ambil"
                                class="btn btn-primary col-xs-12">Cetak Berita Acara Serah Terima
                          </button>
                    </div>
                </div>
            </div>
            
            <div class="box-body table-responsive">
              <table id="table-permintaan" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>                    
                    <th></th>
                    <th>No Reg Tilang</th>
                    <th>Nama Terpidana</th>
                    <th>Alamat Tujuan Antar</th>
                    <th>Nomer Hp</th>
                    <th>Nomer Briva</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data_permintaan["data"] as $item)                  
                    <tr>
                      <td></td>
                      <td>{{ $item->no_reg_tilang }}</td>
                      <td>{{ $item->nama_terpidana }}</td>
                      <td>{{ $item->alamat_antar }}</td>
                      <td>{{ $item->nomer_hp }}</td>
                      <td>{{ $item->nomor_briva }}</td>
                    </tr>                   
                  @endforeach                  
                </tbody>          
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-berita-acara">
          <div class="modal-dialog">
            <div class="modal-content">
                <form id="formSubmitSlur" action="{{ base_url('daftar-permintaan-user') }}" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Informasi Permintaan Pengambilan Barang Bukti</b></h4>
                    </div>              
                    <div class="modal-body">                          
                        <span id="info_pengambilan"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <input type="submit" id="buttonSubmitSlur" name="submit" value="Download Berita Acara" class="btn btn-primary">
                    </div>  
                </form>            
            </div>
          </div>
      </div>
@endsection

@section('page-footer')
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('js/dataTables.checkboxes.min.js') }}"></script>
<script src="{{ asset('js/dataTables.selectlagi.min.js') }}"></script>

<script>
  

  $(document).ready(function(){
    var table_permintaan = $('#table-permintaan').DataTable({     
        "columnDefs": [{
            orderable: true,            
            targets: 0,
            checkboxes: {
              'selectRow': true,
              'selectCallback' : function(){
                // alert("aw");
              }
            }          
        }],
        'select': {
          'style': 'multi',               
        },
        'order': [[1, 'asc']]                 
    });

    $("#btn_ambil").click(function(){
        let jumlah      = $(this).data('jumlah');   
        let form        = $("#formSubmitSlur");
        let buttonSubmitSlur = $("#buttonSubmitSlur");

        let banyak      = table_permintaan.rows('.selected').data().length;
        
        var ids = $.map(table_permintaan.rows('.selected').data(), function (item) {
          return item[1]
        });

        if(banyak > 0 ){
          $("#info_pengambilan").text("Anda akan melakukan permintaan pengambilan barang bukti tilang sebanyak " + banyak + " buah. Silahkan download berita acara di bawah ini sebagai syarat pengambilan barang bukti tilang di kejaksaan.");
        } else {
          $("#info_pengambilan").text("Silahkan pilih data tilang terlebih dahulu");
        }
         

        $("#selected_id_slur").remove();
        $('<input>', {
              type: 'hidden',
              id: 'selected_id_slur',
              name: 'selected_id',
              value: banyak > 0 ? ids : null
          }).appendTo(form);    

        buttonSubmitSlur.prop('disabled', banyak > 0 ? false : true); 
        console.log(ids)           
    });

    
  });

  function getTablePermintaan(){}

 

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