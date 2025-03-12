<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdyalRapportMedDyalyseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdyal_rapport_med_dyalyse', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteDyalise')->constrained('tdyal_entete_dyalise')->restrictOnUpdate()->restrictOnDelete();
            $table->string('rensMedicant',100);
            $table->string('nephropatie',100);
            $table->date('dateSeance',100);
            $table->string('voieAcces',100);
            $table->string('technineFonction',100);
            $table->string('traitement_dialyse',100);
            $table->string('typeDialyse',100);
            $table->string('Generateur',100);
            $table->string('dialyseur',100);
            $table->string('joursDyalise',100);
            $table->string('dureeDyalise',100);
            $table->string('tempsDyalise',100);
            $table->string('anticoagulation',100);
            $table->string('poidsSec',100);
            $table->string('prisePoids',100);
            $table->string('UFMaxtolere',100);
            $table->string('debitPrompe',100);
            $table->string('TAhabituelle',100);
            $table->string('valeurDialysat',100);
            $table->string('nA',100);
            $table->string('k',100);
            $table->string('ca',100);
            $table->string('chloride',100);
            $table->string('hco3',100);
            $table->string('mg',100);
            $table->string('acitate',100);
            $table->string('evolution',100);
            $table->string('conclusion',100);
            $table->string('recommandation',100);
            $table->string('nb',100);
            $table->string('dr',100);
            $table->string('specialite',100);
            $table->string('cNom',100);
            $table->string('author',100);
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
        Schema::dropIfExists('tdyal_rapport_med_dyalyse');
    }
}
