<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_detailfacturation extends Model
{
    protected $fillable=['id','refEnteteFacturation','refProduit','quantite','prixunitaire','author','montant_taux'];
    protected $table = 'tfin_detailfacturation';
}
