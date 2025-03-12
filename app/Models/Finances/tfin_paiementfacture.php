<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_paiementfacture extends Model
{
    protected $fillable=['id','refEnteteFacturation','montantpaie','datepaie','modepaie',
    'libellepaie','author','montant_taux','refBanque','numeroBordereau'];
    protected $table = 'tfin_paiementfacture';
}
