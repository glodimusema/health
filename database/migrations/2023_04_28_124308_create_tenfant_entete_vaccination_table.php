<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenfantEnteteVaccinationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {          

        Schema::create('tenfant_entete_vaccination', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refMouvement')->constrained('tmouvement')->restrictOnUpdate()->restrictOnDelete();
            $table->string('NomPere',50);
            $table->string('NomMere',50);
            $table->string('ContactPere',15);
            $table->string('ContactMere',15);

            $table->date('dateEntete',50);
            $table->string('numeroEnreg',50);
            $table->double('PoidsNaissance');
            $table->string('ZoneSante',50);
            $table->string('AireSante',50);
            $table->string('CentreSante',50);

            $table->string('Estnedomicile',5);
            $table->string('OrphelinMere',5);
            $table->string('OrphelinPere',5);
            $table->string('FrereSoeur',5);
            $table->string('Mere5Enfants',5);
            $table->string('EnfantJumeau',5);
            $table->string('NaissanceRapproche',5);
            $table->string('Mere18ans',5);

            $table->string('ModeAccouchement',50);
            $table->string('Apgar',50);

            $table->string('Nevaripine',5);
            $table->string('Mortne',5);
            $table->string('Mort24h',5);

            $table->string('ComplicationAccouchement',50);
            $table->string('ReanimationEnfant',50);
            $table->string('ComplicatioPostPartum',50);

            $table->string('VitamineMere',5);
            $table->string('FerMere',5);

            $table->double('TailleNaissance');

            $table->string('CPON',50);
            $table->string('PF',50);
            $table->string('CPS',50);       

            $table->string('TypeAccouchement',50);
            $table->string('AccouchementFOSA',50);

            $table->string('medecin',50);
            $table->string('cnom',50);

            $table->string('author',50);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }
//
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenfant_entete_vaccination');
    }
}
