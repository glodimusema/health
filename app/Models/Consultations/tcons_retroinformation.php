<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcons_retroinformation extends Model
{
    protected $fillable=['id','refDetailCons','date_arrivee','heure_arrivee','diagnostic_retenu',
    'traitement_retenu','modalite_sortie','recommandations','date_retro','hopitals','author'];
    protected $table = 'tcons_retroinformation';
}
//id,refDetailCons,date_arrivee,heure_arrivee,diagnostic_retenu,traitement_retenu,modalite_sortie,recommandations,date_retro,hopitals,author
