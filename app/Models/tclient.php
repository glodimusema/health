<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tclient extends Model
{
    // $table->integer('refAvenue');  
    //         $table->integer('refCategieClient'); 

    protected $fillable=['id','noms','contact','mail','refAvenue','refCategieClient','photo','slug',
    'author','sexe_malade','dateNaissance_malade','etatcivil_malade','numeroMaison_malade',
    'fonction_malade','groupesanguin','personneRef_malade','fonctioPersRef_malade','contactPersRef_malade',
    'organisation_malade','numeroCarte_malade','dateExpiration_malade'];
    protected $table = 'tclient';
}
