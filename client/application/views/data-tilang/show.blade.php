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
          <div class="box box-success">
            <div class="box-header">
                <div class="col-md-4">
                    <a href="{{ base_url('kurir/tambah') }}" type="button" class="btn btn-primary btn-flat pull-left">Tambah Data Tilang</a>
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
            <div class="box-body">
              <table id="table-petugas" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nomor Tilang</th>
                  <th>Nama</th>
                  <th>Kendaraan</th>
                  <th>Barang Bukti</th>
                  <th>Total Denda</th>
                  <th>Posisi Barang Bukti</th>
                  <th>Request Antar</th>
                  <th>Tanggal</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>DD12345</td>
                        <td>Rafli Firdausy Irawan</td>
                        <td>Sepeda Motor</td>
                        <td>STNK</td>
                        <td>Rp 51.000</td>
                        <td>Kejaksaan</td>
                        <td>Tidak</td>
                        <td>13 Maret 2019</td>
                        <td>
                            <a href="#" type="button" class="btn btn-flat btn-info btn-sm">LIHAT</a>
                            <a href="#" type="button" class="btn btn-flat btn-warning btn-sm">UBAH</a>
                            <a href="#" type="button" class="btn btn-flat btn-danger btn-sm">HAPUS</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>DD12342</td>
                        <td>Sani Hasani</td>
                        <td>Mobil</td>
                        <td>SIM</td>
                        <td>Rp 91.000</td>
                        <td>Kantor Pos</td>
                        <td>Ya</td>
                        <td>14 Maret 2019</td>
                        <td>
                            <a href="#" type="button" class="btn btn-flat btn-info btn-sm">LIHAT</a>
                            <a href="#" type="button" class="btn btn-flat btn-warning btn-sm">UBAH</a>
                            <a href="#" type="button" class="btn btn-flat btn-danger btn-sm">HAPUS</a>
                        </td>
                    </tr>
                </tbody>
              </table>
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
    $(function () {
        $('#table-petugas').DataTable()

        $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Hari Ini'        : [moment(), moment()],
          'Kemarin'         : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          '7 Hari Terakhir' : [moment().subtract(6, 'days'), moment()],
          '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
          'Bulan Ini'       : [moment().startOf('month'), moment().endOf('month')],
          'Bulan Kemarin'   : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        window.location.href = "https://google.com";
      }
    )
    })
</script>
@endsection