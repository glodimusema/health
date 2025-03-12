<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_affectationabone extends Model
{
    protected $fillable=['id','refMalade','refOrganisation', 'tauxcharge', 'statut', 'author'];
    protected $table = 'tconf_affectationabone';
}
