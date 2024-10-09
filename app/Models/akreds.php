<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class akreds extends Model
{
    use HasFactory;
    protected $table = 'akreds'; // or whatever the actual table name is
    protected $fillable = ['pdf', 'prodi', 'sk', 'awal', 'akhir'];
}
