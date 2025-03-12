<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdetailpaiement extends Model
{
    protected $fillable=['id','refEntetepaie','refFrais','montantpaie','modepaie','typetarif','datedetailpaie','author','libelle'];
    protected $table = 'tdetailpaiement';
}
