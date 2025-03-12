<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_actesmedecin extends Model
{
    protected $fillable=['id','refUnite','refSscompte','nom_acte','prix_acte',
    'prix_convention','code_acte','author'];
    protected $table = 'tfin_actesmedecin';
}
