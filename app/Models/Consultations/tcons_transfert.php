<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcons_transfert extends Model
{
    protected $fillable=['id','refDetailCons','date_admission','heure_admission','diagnostic_tranfert',
    'bilan_tranfert','traitement_tranfert','motif_tranfert','date_transfert','heure_transfert',
    'hopital_transfert','medecin_transfert','specialite_transfert','cnom_transfert','author'];
    protected $table = 'tcons_transfert';
}
//id, refDetailCons,date_admission,heure_admission,diagnostic_tranfert,bilan_tranfert,traitement_tranfert,motif_tranfert,date_transfert,heure_transfert,medecin,specialite,cnom,author
