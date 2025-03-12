<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdepense extends Model
{
    protected $fillable=['id','montant','montantLettre','motif','dateOperation',
    'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
    "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
    ,"DateApproCoordi","numeroBE",'author'];
    protected $table = 'tdepense';
}
