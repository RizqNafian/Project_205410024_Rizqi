<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\MstJabatan;
use Illuminate\Support\Facades\DB;

class MstJabatanController extends Controller
{
    //Index
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MstJabatan::select('id','nama_jabatan','tunjangan')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '
                <a href="'.route('mst-jabatan.show',$row->id).'" class="btn btn-primary btn-sm fa fa-eye"></a>
                <a href="'.route('mst-jabatan.edit',$row->id).'" class="edit btn btn-warning btn-sm fa fa-edit"></a> 
                <a href="'.route('mst-jabatan.destroy',$row->id).'" class="delete btn btn-danger btn-sm fa fa-trash"></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('mst-jabatan.index');
    }
    //view Show
    public function show($id)
    {
        $mstJabatan = MstJabatan::find($id);
        return view('mst-jabatan.show', compact('mstJabatan'));
    }
    //View Store
    public function create()
    {
        $mstJabatan = new MstJabatan();
        return view('mst-jabatan.create', compact('mstJabatan'));
    }
    //Store
    public function store(Request $request)
    {
        request()->validate(MstJabatan::$rules);
        DB::beginTransaction();
        try{
            $jabatan= new MstJabatan();
            $jabatan->nama_jabatan=$request->nama_jabatan;
            $jabatan->tunjangan =$request->tunjangan;
            $jabatan->save();
            DB::commit();
            return redirect()->route('mst-jabatan.index')
            ->with('success', 'MstJabatan telah berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->route('mst-jabatan.index')
            ->with('success', 'Penyimpanan dibatalkan semua, ada kesalahan...');
        }
    }
    //View Edit 
    public function edit($id)
    {
        $mstJabatan = MstJabatan::find($id);
        return view('mst-jabatan.edit', compact('mstJabatan'));
    }
    //Update
    public function update(Request $request,$id)
    {
        request()->validate(MstJabatan::$rules);
        DB::beginTransaction();
        try{
            $jabatan= MstJabatan::find($id);
            $jabatan->nama_jabatan=$request->nama_jabatan;
            $jabatan->tunjangan =$request->tunjangan;
            $jabatan->save();
            DB::commit();
            return redirect()->route('mst-jabatan.index')
            ->with('success', 'MstJabatan berhasil diubah');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->route('mst-jabatan.index')
            ->with('success', 'MstJabatan batal diubah, ada kesalahan');
        }
    }
    //Destroy
    public function destroy($id)
    {    
        DB::beginTransaction();
        try{
            $mstJabatan = MstJabatan::find($id)->delete();
            DB::commit();
            return redirect()->route('mst-jabatan.index')
            ->with('success', 'MstJabatan berhasil dihapus');
        } catch (\Throwable $e) {
        DB::rollback();
        return redirect()->route('mst-jabatan.index')
        ->with('success',
        'MstJabatan ada kesalahan hapus batal... ');
        }
    }
}
