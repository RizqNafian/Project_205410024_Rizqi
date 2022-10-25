@extends('adminlte::page')
@section('title', 'AdminLTE')
@section('content_header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
    </ol>
 </nav>
@stop
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex;justify-content: space-between;align-items: center;">
                        <span id="card_title">
                            <h3>Tabel Master Pegawai</h3>
                        </span>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
                <div class="card-body">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered " id="pangkat_datatable">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Jabatan</th>
                                    <th width="130px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><br>
@stop
@section('js')
<script src="https://kit.fontawesome.com/1f297b51fc.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(function () {
        var table = $('#pangkat_datatable').DataTable({
            "searching": true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('riwayat-pangkat.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                {data: 'id', name: 'id'},
                {data: 'nama', name: 'nama'},
                {data: 'alamat', name: 'alamat'},
                {data: 'nama_jabatan', name: 'nama_jabatan'},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
            ]
        });
    });
</script>
@stop
