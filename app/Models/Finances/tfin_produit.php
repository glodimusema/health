<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_produit extends Model
{
    protected $fillable=['id','refTypeProduit','refSscompte','nom_produit',
    'prix_produit','prix_convention','code_produit','refCategorieSociete','author'];
    protected $table = 'tfin_produit';
}
