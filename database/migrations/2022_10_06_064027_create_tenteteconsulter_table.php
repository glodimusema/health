<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetenteteconsulterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenteteconsulter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailTriage')->constrained('tdetailtriage')->restrictOnUpdate()->restrictOnDelete();
            $table->integer('refMedecin');                     
            $table->date('dateConsultation');
            $table->string('TypeOrientation')->default('CONSULTATIONS');            
            $table->string('statutentetecons')->default('Attente');
            $table->string('cloture')->default('NON');
            $table->foreignId('refLitUrgence')->constrained('tlit')->restrictOnUpdate()->restrictOnDelete();
            $table->string('finUrgence')->default('NON');
            $table->string('parcours')->default('Consultation');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();

            //Consultation, Analyse, Resultat
           
        });

        //TypeOrientation
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenteteconsulter');
    }
}
