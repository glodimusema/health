<?php

namespace App\Models\Reanimation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trea_observation_rea extends Model
{

    protected $fillable=['id','refEnteteRea','detailObservation','auther'];
    protected $table = 'trea_observation_rea';
}
