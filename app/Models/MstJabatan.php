<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstJabatan extends Model
{
    protected $table = 'mst_jabatan';
    protected $primaryKey = 'id';
    static $rules = [
        'nama_jabatan' => 'required',
        'tunjangan' => 'required',
    ];
    protected $fillable = ['nama_jabatan','tunjangan'];
}
