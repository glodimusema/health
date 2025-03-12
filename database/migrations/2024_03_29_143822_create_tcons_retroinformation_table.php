<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconsRetroinformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcons_retroinformation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailCons')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_arrivee');
            $table->string('heure_arrivee');
            $table->string('diagnostic_retenu');
            $table->string('traitement_retenu');
            $table->string('modalite_sortie');
            $table->string('recommandations');
            $table->date('date_retro');
            $table->string('hopitals',100);
            $table->string('author',100);
            $table->timestamps();
        });
    }

    //id,refDetailCons,date_arrivee,heure_arrivee,diagnostic_retenu,traitement_retenu,modalite_sortie,recommandations,date_retro,hopitals,author

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcons_retroinformation');
    }
}
