<?php

namespace App\Models\Reanimation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trea_evolution_rea extends Model
{

    protected $fillable=['id','refHospi','observation','author'];
    protected $table = 'trea_evolution_rea';
}
