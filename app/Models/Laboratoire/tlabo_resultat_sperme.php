<?php

namespace App\Models\Laboratoire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlabo_resultat_sperme extends Model
{
    protected $fillable=['id','refEnteteLabo','refNatureEchantillon','designation_valeur','author'];
    protected $table = 'tlabo_resultat_sperme';
}
