<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmouvement extends Model
{
    protected $fillable=['id','refMalade','refTypeMouvement','idOrganisation','agemvt','age_jourmvt','age_moismvt',
    'dateMouvement','organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt',
    'categoriemaladiemvt','numCartemvt','numroBon','Statut','dateSortieMvt','motifSortieMvt',
    'autoriseSortieMvt','author'];
    protected $table = 'tmouvement';
}
