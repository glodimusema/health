<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_rubriquesurveillance extends Model
{
    protected $fillable=['id','nom_rubliquesurv'];
    protected $table = 'tope_rubriquesurveillance';
}
