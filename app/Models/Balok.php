<?php

namespace App\Models;

class Balok extends SegiEmpat
{
    public $tebal; //properti
    /**************************
    method menghitung volume
    ***************************/
    public function volume()
    {
        return $this->tebal * $this->luas();
    }
}
