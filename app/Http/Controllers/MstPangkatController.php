<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\MstPangkat;
use Illuminate\Support\Facades\DB;

class MstPangkatController extends Controller
{
    //index
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MstPangkat::select('id','nama_pangkat','pangkat_gol')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '
                <a href="'.route('mst-pangkat.show',$row->id).'" class="btn btn-primary btn-sm fa fa-eye"></a>
                <a href="'.route('mst-pangkat.edit',$row->id).'" class="edit btn btn-warning btn-sm fa fa-edit"></a> 
                <a href="'.route('mst-pangkat.destroy',$row->id).'" class="delete btn btn-danger btn-sm fa fa-trash"></a>';
                return $btn;
            })
            ->rawColumns(['action','no'])
            ->make(true);
        }
        return view('mst-pangkat.mst-pangkat');
    }
    //view Show
    public function show($id)
    {
        $mstPangkat = MstPangkat::find($id);
        return view('mst-pangkat.show', compact('mstPangkat'));
    }
    //View Store
    public function create()
    {
        $mstPangkat = new MstPangkat();
        return view('mst-pangkat.create', compact('mstPangkat'));
    }
    //Store
    public function store(Request $request)
    {
        request()->validate(MstPangkat::$rules);
        DB::beginTransaction();
        try{
            DB::table('mst_pangkat')->insert([
            'nama_pangkat'=>$request->nama_pangkat,
            'pangkat_gol'=>$request->pangkat_gol,
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s')
            ]);
            DB::commit();
            return redirect()->route('mst-pangkat.index')
            ->with('success', 'Master Tabel Pangkat created successfully.');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->route('mst-pangkat.index')
            ->with('success','Penyimpanan dibatalkan semua, ada kesalahan......');
        } 
    }
    //View Edit 
    public function edit($id)
    {
        $mstPangkat = MstPangkat::find($id);
        return view('mst-pangkat.edit', compact('mstPangkat'));
    }
    //Update
    public function update(Request $request,$id)
    {
        request()->validate(MstPangkat::$rules);
        DB::beginTransaction();
        try{
            DB::table('mst_pangkat')->where('id',$id)->update([
                'nama_pangkat'=>$request->nama_pangkat,
                'pangkat_gol'=>$request->pangkat_gol,
                'updated_at'=>date('Y-m-d H:m:s')]);
            DB::commit();
            return redirect()->route('mst-pangkat.index')
            ->with('success', 'MstPangkat updated successfully');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->route('mst-pangkat.index')
            ->with('success',
            'Tabel Pangkat Batal diubah, ada kesalahan');
        }
    }
    //Delete
    public function destroy($id)
    {
        MstPangkat::find($id)->delete();
        return redirect()->route('mst-pangkat.index')
        ->with('success', 'Berhasil menghapus user');
    }
}
