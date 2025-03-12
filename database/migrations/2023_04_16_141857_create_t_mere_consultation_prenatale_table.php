<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMereConsultationPrenataleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //goitre,donner_MII  : partenaire_date2,resultat_test3,date_annonce
        Schema::create('t_mere_consultation_prenatale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailConst')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->string('rh',20)->nullable();
            $table->string('electropherese',20)->nullable();
            $table->date('date_debut',10)->nullable();
            $table->string('personne_contact',50)->nullable();
            $table->string('adresse_personne_ref',50)->nullable();
            $table->datetime('date_DDr')->nullable();
            $table->datetime('date_DPA')->nullable();
            $table->string('primipare',5)->nullable();
            $table->string('plus_35',5)->nullable();
            $table->string('tbc',5)->nullable();
            $table->string('hta',5,5)->nullable();
            $table->string('sca',5)->nullable();
            $table->string('dbt',5)->nullable();
            $table->string('car',5)->nullable();
            $table->string('mef',5)->nullable();
            $table->string('raa',5)->nullable();
            $table->string('syphylis',5)->nullable();
            $table->string('vIH_sida',5)->nullable();
            $table->string('vvS',5)->nullable();
            $table->string('pEP',5)->nullable();
            $table->string('cesarienne',5)->nullable();
            $table->string('cerciage',5)->nullable();
            $table->string('fibrame',5)->nullable();
            $table->string('fature_bassin',5)->nullable();
            $table->string('gEU',5)->nullable();
            $table->string('fistule',5)->nullable();
            $table->string('uterus_cicatrice',5)->nullable();
            $table->string('traitement_sterilite',5)->nullable();
            $table->string('parite',5)->nullable();
            $table->string('gestile',5)->nullable();
            $table->string('EnfantEnvie',5)->nullable();
            $table->string('Avortement',5)->nullable();
            $table->string('dystocie',5)->nullable();
            $table->string('eutocie',5)->nullable();
            $table->string('plusGrosPoids',5)->nullable();
            $table->string('plus4kg',5)->nullable();
            $table->string('premature',5)->nullable();
            $table->string('poste_mature',5)->nullable();
            $table->string('mort_ne',5)->nullable();
            $table->string('mort_avant_7j',5)->nullable();
            $table->date('DernierAcouchement')->nullable();
            $table->string('interval2ans',5)->nullable();
            $table->string('complication_post_non',5)->nullable();
            $table->string('compl_post_oui',5)->nullable();
            $table->string('Si_oui_lesquelles',50)->nullable();
            $table->string('malnutrition',5)->nullable();
            $table->string('goitre',5)->nullable();
            $table->string('conjoctives7g',5)->nullable();
            $table->string('conjoctivesIcterifars',5)->nullable();
            $table->string('TA_systolique',10)->nullable();
            $table->string('TA_diastolique1',10)->nullable();
            $table->string('TA_diastolique2',10)->nullable();
            $table->string('proteine',5)->nullable();
            $table->string('festule_reparee',5)->nullable();
            $table->string('discondance',5)->nullable();
            $table->string('bcf',5)->nullable();
            $table->string('mouvementFoctaux',5)->nullable();
            $table->string('pres_transversale',5)->nullable();
            $table->string('bassin_aetreci',5)->nullable();
            $table->string('bassin_limite',5)->nullable();
            $table->string('anomalie',5)->nullable();
            $table->string('uterus_cicotricile',5)->nullable();
            $table->string('masse_supecte',5)->nullable();
            $table->string('maladie_chronique',5)->nullable();
            $table->string('drepanocytose',5)->nullable();
            $table->string('Autres_raisons',5)->nullable();
            $table->datetime('date_references')->nullable();
            $table->datetime('date_du_debutCTX')->nullable();
            $table->string('aZT',20)->nullable();
            $table->string('tAR',20)->nullable();
            $table->string('cd4',5)->nullable();
            $table->string('dors_mil_oui',5)->nullable();
            $table->string('donner_MII',5)->nullable();
            $table->string('fer_acide',5)->nullable();
            $table->string('apres_Accouchement',5)->nullable();
            $table->string('vermifuge',5)->nullable();
            $table->string('Rpr',5)->nullable();
            $table->string('rPR_positif_oui',5)->nullable();
            $table->string('depistage_cancer',50)->nullable();
            $table->string('depistage_TBc',50)->nullable();
            $table->string('traitement_TBc',50)->nullable();
            $table->string('conseilsPF',5)->nullable();
            $table->string('methodePFchoisie',50)->nullable();
            $table->string('dCIP',30)->nullable();
            $table->string('pTME',5)->nullable();
            $table->string('resultat_test1',5)->nullable();
            $table->datetime('date_annonce1')->nullable();
            $table->string('partenaire_date1',50)->nullable();
            $table->string('resultat_test2',5)->nullable();
            $table->datetime('date_annonce2')->nullable();
            // $table->string('partenaire_date2')->nullable();
            // $table->string('resultat_test3')->nullable();
            // $table->date('date_annonce')->nullable();
            $table->string('plau_accouchement',5)->nullable();
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
        Schema::dropIfExists('t_mere_consultation_prenatale');
    }
}
