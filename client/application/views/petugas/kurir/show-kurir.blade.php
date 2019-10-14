@extends('layout.admin')

@section('tab-title')
    Petugas Kurir
@endsection

@section('page-title')
Petugas Kurir
@endsection

@section('page-header')

@endsection

@section('page-breadcrumb')
<li><a href="{{ base_url('dashboard') }}"><i class="fa fa-dashboard"></i> GO BANG</a></li>
<li class="active">Petugas Kurir</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header">
                <a href="{{base_url('kurir/tambah')}}" type="button" class="btn btn-primary btn-flat pull-left">Tambah Petugas Kurir</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="table-petugas" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Admin</th>
                  <th>Nama</th>
                  <th>Nomer Hp</th>
                  <th>Jenis Kelamin</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>KR-001</td>
                        <td>Rafli Firdausy Irawan</td>
                        <td>085726096515</td>
                        <td>Pria</td>
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
<script src=" {{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src=" {{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function () {
        $('#table-petugas').DataTable()
    })
</script>
@endsection