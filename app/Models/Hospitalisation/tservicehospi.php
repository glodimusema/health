<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tservicehospi extends Model
{
    protected $fillable=['id','nom_servicehospi','prix_servicehospi','author'];
    protected $table = 'tservicehospi';
}
