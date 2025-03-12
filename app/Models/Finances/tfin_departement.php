<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_departement extends Model
{
    protected $fillable=['id','nom_departement','code_departement','author'];
    protected $table = 'tfin_departement';  
}
