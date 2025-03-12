<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlabo_entete_prelevement extends Model
{
    protected $fillable=['id','refDetailCons','refService','dateprelevement','numroRecu',
    'MedecinDemandeur',"statutprelevement","preleveur",'author'];
    protected $table = 'tlabo_entete_prelevement';
}
