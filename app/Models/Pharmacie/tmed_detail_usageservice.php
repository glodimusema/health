<?php

namespace App\Models\Pharmacie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmed_detail_usageservice extends Model
{
    protected $fillable=['id','refEnteteVente','refmedicament','qte_usage','pu_usage','observation_usage','author'];
    protected $table = 'tmed_detail_usageservice';


    //tmed_entetebesoin id,refService,refMouvement,refSalle,date_besoin,author
    //tmed_detailbesoin id,refEnteteVente,refmedicament,qte_besoin,pu_besoin,observation_besoin,author
    //tmed_entete_usageservice id,refService,refMouvement,refSalle,date_usage,author
    //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
}
