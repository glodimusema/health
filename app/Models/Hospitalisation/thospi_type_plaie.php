<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_type_plaie extends Model
{
    protected $fillable=['id','nomTypePlaie'];
    protected $table = 'thospi_type_plaie';
}

