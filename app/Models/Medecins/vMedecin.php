<?php

namespace App\Models\Medecins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vMedecin extends Model
{
    protected $fillable=['id','matricule_medecin','noms_medecin','sexe_medecin','datenaissance_medecin',
    'lieunaissnce_medecin','provinceOrigine_medecin','etatcivil_medecin','refAvenue_medecin',
    'contact_medecin','mail_medecin','grade_medecin','fonction_medecin','specialite_medecin',
    'Categorie_medecin','niveauEtude_medecin','anneeFinEtude_medecin','Ecole_medecin','photo','slug','nomAvenue',
    'idCommune','nomQuartier','idQuartier','idVille',
    'nomCommune','idProvince','nomVille','idPays','nomProvince',
    'nomPays','age_medecin','author','created_at','updated_at'];
    protected $table = 'vmedecin';
}
