<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdetailtriage extends Model
{
    protected $fillable=['id','refEnteteTriage','plainte_triage','antecedent_trige','cas_triage','Poids','Taille','TA','Temperature','FC','FR','Oxygene','author'];
    protected $table = 'tdetailtriage';
}
