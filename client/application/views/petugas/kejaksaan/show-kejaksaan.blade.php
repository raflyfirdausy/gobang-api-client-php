@extends('layout.admin')

@section('tab-title')
    Admin Kejaksaan
@endsection

@section('page-title')
Admin Kejaksaan
@endsection

@section('page-header')
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('page-breadcrumb')
<li><a href="{{ base_url('dashboard') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
<li class="active">Petugas Kejaksaan</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Nomer Hp</th>
                  <th>Jenis Kelamin</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($admin as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nip }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->no_hp }}</td>
                        <td>{{ $data->jenis_kelamin }}</td>
                        <td>
                            <a href="#" type="button" class="btn btn-primary btn-sm">LIHAT</a>
                            <a href="#" type="button" class="btn btn-warning btn-sm">UBAH</a>
                            <a href="#" type="button" class="btn btn-danger btn-sm">HAPUS</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Nomer Hp</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
@endsection

@section('page-footer')
<script src=" {{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src=" {{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function () {
        $('#example1').DataTable()
    })
</script>
@endsection