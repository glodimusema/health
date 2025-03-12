<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlabo_detail_examencolore extends Model
{
    protected $fillable=['id','refResultatBacterie','refExamenColore','Resultatexamen','author'];
    protected $table = 'tlabo_detail_examencolore';
}
