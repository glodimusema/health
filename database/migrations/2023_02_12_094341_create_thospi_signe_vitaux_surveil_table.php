<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiSigneVitauxSurveilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('thospi_signe_vitaux_surveil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refSurvHospi')->constrained('thospi_surveillance_hospie')->restrictOnUpdate()->restrictOnDelete();
            $table->string('heure',10)->nullable();
            $table->string('temperatureSurv',10)->nullable();
            $table->string('TA',10)->nullable();
            $table->string('respiration',100)->nullable();
            $table->string('pulsation',100)->nullable();
            $table->string('qtepulsation',100)->nullable();
            $table->string('etatconscience',100)->nullable();
            $table->string('mouvement',100)->nullable();
            $table->string('vomissement',100)->nullable();
            $table->string('qteVomissement',100)->nullable();
            $table->string('diarhee',100)->nullable();
            $table->string('qteDiarhee',100)->nullable();
            $table->string('drainGauche',100)->nullable();
            $table->string('drainDroite',100)->nullable();
            $table->string('duirese',100)->nullable();
            $table->string('qteDuirese',100)->nullable();
            $table->string('perfusion',100)->nullable();
            $table->string('qtePerfusion',100)->nullable();
            $table->string('AborVeineux',100)->nullable();
            $table->string('Glycemie',100)->nullable();
            $table->string('hemoragie',100)->nullable();
            $table->string('oxygene',100)->nullable();
            $table->string('pensement',100)->nullable();
            $table->string('detailPensement',100)->nullable();
            $table->string('observation',100)->nullable();
            $table->string('author',100)->nullable();
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
        Schema::dropIfExists('thospi_signe_vitaux_surveil');
    }
}
