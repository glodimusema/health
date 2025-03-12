<?php

namespace App\Models\Pharmacie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmed_entete_vente extends Model
{
    protected $fillable=['id','refMouvement','dateVente','author'];
    protected $table = 'tmed_entete_vente';
}
