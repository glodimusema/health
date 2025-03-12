<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlaboResultatBacteriologieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tlabo_resultat_bacteriologie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteLabo')->constrained('tentetelabo')->restrictOnUpdate()->restrictOnDelete();
            $table->date('datePrelevement',10);  
            $table->date('dateResultat',10); 
            $table->string('aspectmacro',100);    
            $table->string('examenFrais',100);
            $table->string('autreColoration',100);
            $table->string('autresGerme',100);
            $table->string('Sensible',100);
            $table->string('Intermediaire',100);
            $table->string('resistant',100);
            $table->string('technicien',50);
            $table->string('directeurTechnique',50);        
            $table->string('author',50); 
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }

    //tlabo_resultat_bacteriologie
    //id,refEntetePrelevement,datePrelevement,dateResultat,aspectmacro,examenFrais,autresGerme,
    //Sensible,Intermediaire,resistant,technicien,directeurTechnique,author
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tlabo_resultat_bacteriologie');
    }
}
