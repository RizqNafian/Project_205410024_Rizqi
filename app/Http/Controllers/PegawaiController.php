<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class PegawaiController extends Controller
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
                <a href="'.route('pegawai.show',$row->id).'" class="btn btn-primary btn-sm fa fa-eye"></a>
                <a href="'.route('pegawai.edit',$row->id).'" class="edit btn btn-warning btn-sm fa fa-edit"></a> 
                <a href="'.route('pegawai.destroy',$row->id).'" class="delete btn btn-danger btn-sm fa fa-trash"></a>';
                return $btn;
            })
            ->rawColumns(['action','no'])
            ->make(true);
        }
        return view('pegawai.index');
    }
    //Create
    public function create()
    {
        $jabatan=DB::table('mst_jabatan')->pluck('nama_jabatan','id');
        $pegawai = new Pegawai();
        return view('pegawai.create', compact('pegawai','jabatan'));
    }
    //Store
    public function store(Request $request)
    {
        request()->validate(Pegawai::$rules);
        DB::beginTransaction();
        try{
            $file = $request->file('file_foto');
            $ext = $file->getClientOriginalExtension();
            $fileFoto = $request->id.".".$ext;
            $request->file('file_foto')->move("foto/", $fileFoto);
            DB::table('pegawai')->insert([
                'id'=>$request->id,
                'nama'=>$request->nama,
                'alamat'=>$request->alamat,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'jenis_kel'=>$request->jenis_kel,
                'agama'=>$request->agama,
                'telepon'=>$request->telepon,
                'email'=>$request->email,
                'file_foto'=>$fileFoto,
                'mst_jabatan_id'=>$request->mst_jabatan_id,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
            DB::commit();
            return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai telah berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->route('pegawai.index')
            ->with('success', 'Penyimpanan dibatalkan semua, ada kesalahan...');
        }
    }
    //Edit
    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
        $jabatan=DB::table('mst_jabatan')->pluck('nama_jabatan','id');
        return view('pegawai.edit', compact('pegawai','jabatan'));
    }
    //Update
    public function update(Request $request,$id)
    {
        request()->validate(Pegawai::$rules);
        DB::beginTransaction();
        try{
            $pegawai = Pegawai::find($id);
            if ($request->hasFile('file_foto'))
            {
                $image_path = "foto/".$pegawai->file_foto;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $file = $request->file('file_foto');
                $ext = $file->getClientOriginalExtension();
                $fileFoto = $id.".".$ext;
                $destinationPath = 'foto/';
                $file->move($destinationPath, $fileFoto);
            } else {
                $fileFoto = $pegawai->file_foto;
            }
            DB::table('pegawai')->where('id',$id)->update([
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
            'jenis_kel'=>$request->jenis_kel,
            'tanggal_lahir'=>$request->tanggal_lahir,
            'agama'=>$request->agama,
            'telepon'=>$request->telepon,
            'email'=>$request->email,
            'file_foto'=> $fileFoto,
            'mst_jabatan_id'=>$request->mst_jabatan_id,
            'updated_at'=>date('Y-m-d H:i:s'),]);
            DB::commit();
            return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil diubah');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai batal diubah, ada kesalahan');
        }
    }
    //Show
    public function show($id)
    {
        $pegawai = Pegawai::find($id);
        return view('pegawai.show', compact('pegawai'));
    }
    //Destroy
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $pegawai = Pegawai::find($id)->delete();
            DB::commit();
            return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai ada kesalahan hapus batal... ');
        }
    }
}
