<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstPangkat extends Model
{   
    protected $table = 'mst_pangkat';
    protected $fillable = ['nama_pangkat','pangkat_gol'];
    static $rules = [
    'nama_pangkat' => 'required',
    'pangkat_gol' => 'required'
    ];
}
