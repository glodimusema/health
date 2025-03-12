<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinRapportmedicalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_rapportmedical', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailCons')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();             
            $table->string('plainte_med'); 
            $table->string('historique_med'); 
            $table->string('antecedent_med');           
            $table->string('examenphysique_med'); 
            $table->string('diagnostic_med'); 
            $table->string('examenparaclinique_med');
            $table->string('traitement_med');
            $table->string('evolution_med');
            $table->string('libelle_med');
            $table->date('date_med'); 
            $table->string('medecin_med'); 
            $table->string('specialite_med'); 
            $table->string('cnom_med');     
            $table->string('statut_rapmed')->default('Attente');       
            $table->string('author');
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
        Schema::dropIfExists('tfin_rapportmedical');
    }
}
