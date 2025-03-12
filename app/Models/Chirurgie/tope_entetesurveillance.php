<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tope_entetesurveillance extends Model
{
    protected $fillable=[
    'id','refAnesthesie','refDepartement','dateSurveillance','chirurgien','anesthesiste',
    'infirmierSalle','heureAdmiSalle','heureDebutInterv','diagnosticOpe','acteOpe','heureFin',
    'autresCommentaires','author'
];
    protected $table = 'tope_entetesurveillance';

            
}
