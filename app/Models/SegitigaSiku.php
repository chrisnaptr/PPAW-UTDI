<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegitigaSiku extends Model
{
    public $alas;
    public $tinggi;
    public function kalkulasi_miring()
    {
        return sqrt(pow($this->alas, 2) + pow($this->tinggi, 2));
    }
    public function luas()
    {
        return ($this->alas * $this->tinggi) / 2;
    }
    public function keliling()
    {
        return $this->alas + $this->tinggi + $this->kalkulasi_miring();
    }
}