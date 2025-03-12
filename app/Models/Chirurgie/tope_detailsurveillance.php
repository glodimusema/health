<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_detailsurveillance extends Model
{
    protected $fillable=[
    'id','refEnteteSurv','refRubrique','libres','encombres','ampleERugiliere','disphee',
    'lucide','marcose','propre','souille','normale','nonretablie','observationSurv', 
    'Observe1','Observe2','Observe3','author'
    ];
    protected $table = 'tope_detailsurveillance';

    
}
