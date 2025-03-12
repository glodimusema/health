<?php

namespace App\Models\Logistique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tproduit extends Model
{
    protected $fillable=['id','designation','pu','unite','refCategorie','author'];
    protected $table = 'tproduit';
}
