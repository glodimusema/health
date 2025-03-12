<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_entetefacturation extends Model
{
    protected $fillable=['id','refMouvement','refUniteProduction','refMedecin','datefacture','statut','author'];
    protected $table = 'tfin_entetefacturation';
}
