<?php

namespace App\Models\Chirurgie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class top_cons_preanesthesie extends Model
{
    protected $fillable=[
    
    "id","refEnteteOperation","TypeIntervension","diagnostic_preoperatoire","antecedents_cpa","rhume","dyspnee_1",
    "Toux","spo2_1","crachats","Examen_Poumons","Palpitations","dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur",
    "Nausees","Epigastralgie","Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
    "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale","Distance_thyro",
    "Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation","Consculsion_CPA","Premedication",
    "Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA","ConsentementEclaire",
    "author"
];
protected $table = 'top_cons_preanesthesie';

}
