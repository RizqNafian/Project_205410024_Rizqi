@extends('adminlte::page')
@section('title', 'AdminLTE')
@section('content_header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tabel Master Pegawai</li>
        <li class="breadcrumb-item active" aria-current="page">{{$peg->nama}}</li>
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
                            <h3>Riwayat Kepangkatan Pegawai</h3>
                        </span>
                        <div class="float-right">
                            <h2><a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-sm">Add</a></h2>
                        </div>
                    </div>
                </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    <table align="center" width="60%">
                        <tr>
                            <td>NIP </td>
                            <td> : {{ $peg->id }} </td>
                        </tr>
                        <tr>
                            <td>Nama </td>
                            <td> : {{ $peg->nama }} </td>
                        </tr>
                        <tr>
                            <td>Pangkat/Golongan Terakhir </td>
                            <td> : {{$peg->pGolTerahir()}}</td>
                        </tr>
                        <tr>
                            <td>Masa Kerja Pangkat/Golongan </td>
                            <td> : {{$peg->masaKerjaGol($peg->id )}}</td>
                        </tr>
                    </table>
                <div class="card-body">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered " id="pangkat_datatable">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>TGL TMT</th>
                                    <th>NO SK</th>
                                    <th>NAMA PANGKAT</th>
                                    <th>GOL/RUANG</th>
                                    <th>GAJI POKOK</th>
                                    <th>STATUS</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1 @endphp
                                @foreach ($rw as $peg)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $peg->tanggal_tmt_pangkat }}</td>
                                    <td>{{ $peg->no_sk_pangkat }}</td>
                                    <td>{{ $peg->getPangkat->nama_pangkat ==null ? "Belum punya" :$peg->getPangkat->nama_pangkat}}</td>
                                    <td>{{ $peg->getPangkat->pangkat_gol}}</td>
                                    <td>{{ $peg->gaji_pokok}}</td>
                                    <td>{{ $peg->status==0 ? "Tidak" :"Berlaku"}}</td>
                                    <td>
                                        <a href="{{route('riwayat-pangkat.edit',$peg->id)}}" class="btn btn-primary btn-sm fa fa-eye"></a>
                                        <a href="{{route('riwayat-pangkat.destroy',$peg->id)}}" class="btn btn-danger btn-sm fa fa-trash"></a>
                                    </td>
                                </tr>
                                @endforeach
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
            dom: ''
        });
    });
</script>
@stop

