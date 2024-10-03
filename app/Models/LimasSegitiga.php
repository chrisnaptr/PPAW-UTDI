<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimasSegitiga extends \App\Models\SegitigaSiku 
{
    public $luas_alas;
    public $tinggi_limas;
    public function volume()
    {
        return ($this->luas_alas * $this->tinggi_limas) / 3;
    }
}
