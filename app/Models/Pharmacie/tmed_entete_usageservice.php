<?php

namespace App\Models\Pharmacie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmed_entete_usageservice extends Model
{
    protected $fillable=['id','refService','refMouvement','refSalle','date_usage','author'];
    protected $table = 'tmed_entete_usageservice';


    //tmed_entetebesoin id,refService,refMouvement,refSalle,date_besoin,author
    //tmed_detailbesoin id,refEnteteVente,refmedicament,qte_besoin,pu_besoin,observation_besoin,author
    //tmed_entete_usageservice id,refService,refMouvement,refSalle,date_usage,author
    //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
}
