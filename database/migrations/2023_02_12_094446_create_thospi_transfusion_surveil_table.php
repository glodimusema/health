<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiTransfusionSurveilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('thospi_transfusion_surveil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refSurvHospi')->constrained('thospi_surveillance_hospie')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateTransfusion',100)->nullable();
            $table->string('heureDebut',100)->nullable();
            $table->string('heureFin',100)->nullable();
            $table->string('status',100)->nullable();
            $table->string('Nmpoche',100)->nullable();
            $table->date('dateperemption',100)->nullable();
            $table->string('medecinDemandeur',100)->nullable();
            $table->string('nombre',100)->nullable();
            $table->string('reatianTransttut',100)->nullable();
            $table->string('dysphee1',100)->nullable();
            $table->string('ExtrenateCyanosee',100)->nullable();
            $table->string('tachycardie',100)->nullable();
            $table->string('paleurcutaneo',100)->nullable();
            $table->string('extremitesfoides',100)->nullable();
            $table->string('TA_transf',100)->nullable();
            $table->string('agitation',100)->nullable();            
            $table->string('autres1',100)->nullable();
            $table->string('indicationTransf',100)->nullable();
            $table->string('Hb_avant',100)->nullable();
            $table->string('hct_avant',100)->nullable();
            $table->string('Hb_apres',100)->nullable();
            $table->string('hct_apres',100)->nullable();
            $table->string('qteSangTransfuse',100)->nullable();
            $table->string('nature',100)->nullable();
            $table->string('hbTransfusion',100)->nullable();
            $table->string('hct_transfusion',100)->nullable();
            $table->string('compatible',100)->nullable();
            $table->string('temperatureSurv',100)->nullable();
            $table->string('FRtraitSurv',100)->nullable();
            $table->string('FCtraitSurv',100)->nullable();
            $table->string('TAtraitSurv',100)->nullable();
            $table->string('autres2',100)->nullable();
            $table->string('rashCutane',100)->nullable();
            $table->string('frisson',100)->nullable();
            $table->string('troubleRythme',100)->nullable();
            $table->string('nausee',100)->nullable();
            $table->string('temperature2',100)->nullable();
            $table->string('TA2',100)->nullable();
            $table->string('FR2',100)->nullable();
            $table->string('oedemelaynge1',100)->nullable();
            $table->string('diarhee',100)->nullable();
            $table->string('pouls_0a15min',100)->nullable();
            $table->string('oedemelaynge2',100)->nullable();
            $table->string('dysphee2',100)->nullable();
            $table->string('precardialge',100)->nullable();
            $table->string('lambelgue',100)->nullable();
            $table->string('douleurabdominal',100)->nullable();
            $table->string('TA_15a30',100)->nullable();
            $table->string('temperature_15a30',100)->nullable();
            $table->string('pauls_15a30',100)->nullable();
            $table->string('fr_15a30',100)->nullable();
            $table->string('autres3',100)->nullable();
            $table->string('observation1',100)->nullable();
            $table->string('ta_30a1_heure',100)->nullable();
            $table->string('tempera_30a1_heure',100)->nullable();
            $table->string('pauls_30a1heure',100)->nullable();
            $table->string('fr_30a1heure',100)->nullable();
            $table->string('autres4',100)->nullable();
            $table->string('observation2',100)->nullable();
            $table->string('TA_1a2h',100)->nullable();
            $table->string('Pouls_1a2h',100)->nullable();
            $table->string('Temperature_1a2h',100)->nullable();
            $table->string('FR_1a2h',100)->nullable();
            $table->string('autres_1a2h',100)->nullable();
            $table->string('observations_1a2h',100)->nullable();
            $table->string('TA_2ha3h',100)->nullable();
            $table->string('temperature_2ha3h',100)->nullable();
            $table->string('pauls_2ha3h',100)->nullable();
            $table->string('fr_2ha3h',100)->nullable();
            $table->string('observation3',100)->nullable();
            $table->string('autres5',100)->nullable();
            $table->string('autres_2ha3h',100)->nullable();
            $table->string('observationsGenol')->nullable();
            $table->string('author')->nullable();;
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
        Schema::dropIfExists('thospi_transfusion_surveil');
    }
}
