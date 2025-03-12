<?php

namespace App\Models\Pharmacie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmed_entete_sortie extends Model
{
    protected $fillable=['id','refService','nom_agent','dateSortie','libelle','author'];
    protected $table = 'tmed_entete_sortie';
}
