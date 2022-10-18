<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\RiwayatPangkat;
use App\Models\Pegawai;
use App\Models\MstPangkat;

class RiwayatPangkatController extends Controller
{
    //index
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pegawai::join('mst_jabatan','pegawai.mst_jabatan_id','=','mst_jabatan.id')
            ->select('pegawai.id','pegawai.nama','pegawai.alamat','mst_jabatan.nama_jabatan')
            ->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '
                <a href="'.route('riwayat-pangkat.proses',$row->id).'" class="btn btn-primary btn-sm fa fa-eye"></a>';
                return $btn;
            })
            ->rawColumns(['action','no'])
            ->make(true);
        }
        return view('riwayat-pangkat.index');
    }
    //Proses
    public function proses($id)
    {
        $rw=RiwayatPangkat::where('pegawai_id',$id)->get();
        $peg=Pegawai::find($id);
        return view('riwayat-pangkat.index1', compact('rw','peg'));
    }
    //Create
    public function create($peg_id)
    {
        $pangkat=DB::table('mst_pangkat')->pluck(
        DB::raw('CONCAT(pangkat_gol," ",nama_pangkat) as nama_pangkat'),'id');
        $rw = new RiwayatPangkat();
        $peg = Pegawai::find($peg_id);
        return view('riwayat-pangkat.create', compact('rw','pangkat','peg'));
    }
    //Store
    public function store(Request $request)
    {
        $rwp = new RiwayatPangkat;
        $rwp->pegawai_id =$request->pegawai_id;
        $rwp->mst_pangkat_id =$request->mst_pangkat_id;
        $rwp->no_sk_pangkat =$request->no_sk_pangkat;
        $rwp->tanggal_tmt_pangkat=$request->tanggal_tmt_pangkat;
        $rwp->gaji_pokok =$request->gaji_pokok;
        $rwp->status =$request->status;
        $rwp->save();
        $rw = RiwayatPangkat::where('pegawai_id',$request->pegawai_id)->get();
        $peg = Pegawai::find($request->pegawai_id);
        return view('riwayat-pangkat.index1', compact('rw','peg'));
    }
    //edit
    public function edit($id)
    {
        $rw = RiwayatPangkat::find($id);
        $peg_id = RiwayatPangkat::where('id',$id)->first();
        $peg = Pegawai::find($peg_id->pegawai_id);
        $pangkat=DB::table('mst_pangkat')->pluck(
        DB::raw('CONCAT(pangkat_gol," ",nama_pangkat) as nama_pangkat'),'id');
        return view('riwayat-pangkat.edit', compact('rw','peg','pangkat'));
    }
    //update
    public function update(Request $request, $id)
    {
        $rwp = RiwayatPangkat::find($id);
        $rwp->pegawai_id =$request->pegawai_id;
        $rwp->mst_pangkat_id =$request->mst_pangkat_id;
        $rwp->no_sk_pangkat =$request->no_sk_pangkat;
        $rwp->tanggal_tmt_pangkat=$request->tanggal_tmt_pangkat;
        $rwp->gaji_pokok =$request->gaji_pokok;
        $rwp->status =$request->status;
        $rwp->save();
        $rw = RiwayatPangkat::where('pegawai_id',$request->pegawai_id)->get();
        $peg = Pegawai::find($request->pegawai_id);
        return view('riwayat-pangkat.index1', compact('rw','peg'));
    }
    //destroy
    public function destroy($id)
    {
        $peg_id = RiwayatPangkat::find($id)->pegawai_id;
        $rwy = RiwayatPangkat::find($id)->delete();
        $rw = RiwayatPangkat::where('pegawai_id',$peg_id)->get();
        $peg = Pegawai::find($peg_id);
        return view('riwayat-pangkat.index1', compact('rw','peg'));
    }
    // cetak
    public function cetak($id)
    {
        $rw=RiwayatPangkat::where('pegawai_id',$id)->get();
        $peg=Pegawai::find($id);
        return view('riwayat-pangkat.cetak', compact('rw','peg'));
    }
}
