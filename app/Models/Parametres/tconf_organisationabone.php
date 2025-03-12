<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_organisationabone extends Model
{
    protected $fillable=['id','nom_org', 'adresse_org', 'contact_org', 'rccm_org', 'idnat_org',
    'pourcentageConvention','nmbreJourCons','refCategorieSociete', 'author'];
    protected $table = 'tconf_organisationabone';
}
