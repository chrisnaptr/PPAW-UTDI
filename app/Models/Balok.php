<?php 
 
namespace App\Models; 
 
class Balok extends \App\Models\SegiEmpat 
{ 
  public $tebal; 
 
  public function volume() 
  { 
    return $this->panjang * $this->lebar * $this->tebal; 
  } 
 
} 