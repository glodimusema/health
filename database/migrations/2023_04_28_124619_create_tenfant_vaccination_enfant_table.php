<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenfantVaccinationEnfantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenfant_vaccination_enfant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteVac')->constrained('tenfant_entete_vaccination')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refStrategie')->constrained('t_enfant_strategie')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refModeAtteinte')->constrained('t_enfant_mode_attente_enfant')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refVaccin')->constrained('tenfant_vaccin')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateprevue',50);
            $table->date('dateRecu',50);
            $table->double('poids');
            $table->string('observation',50);
            $table->double('taille',50);
            $table->string('author',50);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }
//author
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenfant_vaccination_enfant');
    }
}
