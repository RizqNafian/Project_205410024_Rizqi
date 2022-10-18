<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id','name','email')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('home').'" class="btn btn-primary btn-sm fa fa-eye"></a>';
                    $btn1 = '<a href="'.route('users.destroy',$row->id).'" class="btn btn-warning btn-sm fa fa-edit"></a>';
                    $btn2 = '<a href="'.route('users.destroy',$row->id).'" class="btn btn-danger btn-sm fa fa-trash"></a>';
                    return $btn."&nbsp;&nbsp;".$btn1."&nbsp; ".$btn2;
                })
                ->addColumn('no', function($row){
                    $no = $row->count('id');
                    for ($i=1; $i < $no; $i++) { 
                        return $i;
                    };
                })
                ->rawColumns(['action','no'])
                ->make(true);
        }
        return view('users');
    }
    public function input()
    {
        return view('Home');
    }
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
        ->with('success', 'Berhasil menghapus user');
    }
}