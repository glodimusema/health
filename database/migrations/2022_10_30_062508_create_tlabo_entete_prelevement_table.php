<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlaboEntetePrelevementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //tlabo_entete_prelevement : id,refDetailCons,refService,dateprelevement,numroRecu,MedecinDemandeur,author
        Schema::create('tlabo_entete_prelevement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailCons')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refService')->constrained('tfin_uniteproduction')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateprelevement',50);  
            $table->string('numroRecu',10);  
            $table->string('MedecinDemandeur',50);
            $table->string('statutprelevement',50)->default('Attente');
            $table->string('preleveur',50)->default('NON');
            $table->string('author',50); 
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
        //tfin_uniteproduction
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tlabo_entete_prelevement');
    }
}
