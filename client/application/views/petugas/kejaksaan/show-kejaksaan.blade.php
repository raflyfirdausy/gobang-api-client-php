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
<li><a href="{{ base_url('dashboard') }}"><i class="fa fa-dashboard"></i> GO BANG</a></li>
<li class="active">Petugas Kejaksaan</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                  Tambah Admin Kejaksaan
                </button>                
            </div>
            <div class="box-body">
              <table id="table-petugas" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>                  
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Nomer Hp</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($admin as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>                        
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->no_hp }}</td>
                        <td>                            
                            <a href="#" type="button" data-toggle="modal" data-target="#modal-edit" class="btnEdit btn btn-primary btn-sm">UBAH</a>
                            <a href="#" type="button" data-toggle="modal" data-target="#modal-hapus" class="btn btn-danger btn-sm">HAPUS</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-tambah">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Admin kejaksaan</h4>
              </div>
              <form enctype="multipart/form-data" role="form" method="POST" action="#">
                <div class="modal-body">                
                    <div class="form-group">
                      <label for="nama">Nama</label>                      
                      <input required class="form-control" name="nama" type="text" id="nama">                      
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>                      
                      <input required class="form-control" name="email" type="email" id="email">                      
                    </div>
                    <div class="form-group">
                      <label for="no_hp">No HP (08xx)</label>                                            
                      <input required class="form-control" name="no_hp" type="tel" pattern= "[0-9]+" id="no_hp">                      
                    </div>
                    <div class="form-group">
                      <label for="pass">Password</label>                                            
                      <input required class="form-control" name="pass" type="password" id="pass">                      
                    </div>
                    <div class="form-group">
                      <label for="ulangi_pass">Ulangi Password</label>                                            
                      <input required class="form-control" name="ulangi_pass" type="password" id="ulangi_pass">                      
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
<script src=" {{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src=" {{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function () {
        $('#table-petugas').DataTable()
    })
</script>
@endsection