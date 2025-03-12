<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tservicesoin extends Model
{
    protected $fillable=['id','nom_servicesoin'];
    protected $table = 'tservicesoin';
}
