<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vRecouvrement extends Model
{
    protected $fillable=['id','id','noms','contact','mail','refAvenue','refCategieClient','Categorie','photo','slug','author','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at','idVenteMax','dateVente','NombreJour','Observation'];
    protected $table = 'vrecouvrement';
}
