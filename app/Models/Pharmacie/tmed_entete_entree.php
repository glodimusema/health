<?php

namespace App\Models\Pharmacie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmed_entete_entree extends Model
{
    protected $fillable=['id','refFournisseur','dateEntree','libelle','author'];
    protected $table = 'tmed_entete_entree';
}
