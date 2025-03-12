<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlabo_resultat_bacteriologie extends Model
{
    protected $fillable=['id','refEnteteLabo','datePrelevement','dateResultat','aspectmacro',
    'examenFrais','autreColoration','autresGerme','Sensible','Intermediaire','resistant','technicien','directeurTechnique','author'];
    protected $table = 'tlabo_resultat_bacteriologie';
}
