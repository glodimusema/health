<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vMouvement extends Model
{
    protected $fillable=['id','refMalade','refTypeMouvement','dateMouvement','numroBon','Statut','dateSortieMvt','motifSortieMvt',
    'autoriseSortieMvt','author','created_at','updated_at','Typemouvement','noms','contact','mail','refAvenue','refCategieClient',
    'Categorie','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince',
    'nomPays','sexe_malade','dateNaissance_malade','etatcivil_malade',
    'numeroMaison_malade','fonction_malade','personneRef_malade','fonctioPersRef_malade',
    'contactPersRef_malade','organisation_malade','numeroCarte_malade',
    'dateExpiration_malade','age_malade'];
    protected $table = 'vmouvement';
}
