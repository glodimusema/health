<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vPaiementVente extends Model
{
    protected $fillable=['id','refEnteteVente','montant','datePaie','libelle','author','refClient','dateVente','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at','TotalPaie','Reste'];
    protected $table = 'vpaiementvente';
}
