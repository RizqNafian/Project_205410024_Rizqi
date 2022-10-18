@extends('adminlte::page')
@section('title', 'AdminLTE')
@section('content_header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tabel Pangkat</li>
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
                            <h3>Tabel Master Pangkat</h3>
                        </span>
                        <div class="float-right">
                            <h2><a href="{{ route('mst-pangkat.create') }}" class="btn btn-primary btn-sm">Add</a></h2>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="card-body">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered " id="mst_pangkat_datatable">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Name</th>
                                    <th>Golongan</th>
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
        var table = $('#mst_pangkat_datatable').DataTable({
            "searching": true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('mst-pangkat.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
                {data: 'nama_pangkat', name: 'nama_pangkat'},
                {data: 'pangkat_gol', name: 'pangkat_gol'},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
            ]
        });
    });
</script>
@stop
