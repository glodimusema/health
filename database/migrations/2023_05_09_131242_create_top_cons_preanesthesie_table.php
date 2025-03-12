<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopConsPreanesthesieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // id,refEnteteOperation,TypeIntervension,diagnostic_preoperatoire,antecedents_cpa,rhume,dyspnee_1,
        // Toux,spo2_1,crachats,Examen_Poumons,Palpitations,dyspnee_2,dyspnee_3,spo2_2,Precodialgies,ExamenduCoeur,
        // Nausees,Epigastralgie,Vomissements,Pyrasis,Diarrhees,UlceresGD,Diures,Autres1,Systeme_nerveux,Autres2,
        // TraitementEncours,Malformations,Prothese,Obesite,Estomac_plein,Ouverture_Bucale,Distance_thyro,
        // Mobilite_cervicale,Lips_Test,Mallampatie,Prediction_intubation,Consculsion_CPA,Premedication,
        // Typeanesthesie,AutresTypeAnesthesie,Protocole_CPA,ConsentementEclaire,
        // author
        //
        
        Schema::create('top_cons_preanesthesie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteOperation')->constrained('tope_enteteoperation')->restrictOnUpdate()->restrictOnDelete();
            $table->String('TypeIntervension',100);
            $table->string('diagnostic_preoperatoire',225);    
            $table->string('antecedents_cpa',225);  
            $table->string('rhume',5);    
            $table->string('dyspnee_1',5); 
            $table->string('Toux',5);    
            $table->string('spo2_1',50); 
            $table->string('crachats',5);
            $table->string('Examen_Poumons',225);
            $table->string('Palpitations',100);
            $table->string('dyspnee_2',5); 
            $table->string('dyspnee_3',5); 
            $table->string('spo2_2',50);
            $table->string('Precodialgies',100);
            $table->string('ExamenduCoeur',225);

            $table->string('Nausees',10);
            $table->string('Epigastralgie',10);
            $table->string('Vomissements',10);
            $table->string('Pyrasis',10);
            $table->string('Diarrhees',10);
            $table->string('UlceresGD',10);

            $table->string('Diures',225);
            $table->string('Autres1',225);
            $table->string('Systeme_nerveux',225);
            $table->string('Autres2',225);
            $table->string('TraitementEncours',225);

            $table->string('Malformations',10);
            $table->string('Prothese',10);
            $table->string('Obesite',10);
            $table->string('Estomac_plein',10);
            $table->string('Ouverture_Bucale',10);
            $table->string('Distance_thyro',10);
            $table->string('Mobilite_cervicale',10);
            $table->string('Lips_Test',10);
            $table->string('Mallampatie',10);
            $table->string('Prediction_intubation',10);            

        

            $table->string('Consculsion_CPA',225);
            $table->string('Premedication',225);

            $table->string('Typeanesthesie',20);

            $table->string('AutresTypeAnesthesie',225);
            $table->string('Protocole_CPA',225);
            $table->string('ConsentementEclaire',225);

            $table->string('author',50);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top_cons_preanesthesie');
    }
}
