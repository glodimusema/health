<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_rapportmedical extends Model
{

    protected $fillable=['id','refDetailCons','plainte_med','historique_med','antecedent_med',
    'examenphysique_med','diagnostic_med','examenparaclinique_med','traitement_med',
    'evolution_med','libelle_med','date_med','medecin_med','specialite_med','cnom_med','author'];
    protected $table = 'tfin_rapportmedical';
}
