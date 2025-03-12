<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmedEnteteSortieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmed_entete_sortie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refService')->constrained('tservice_hopital')->restrictOnUpdate()->restrictOnDelete();  
            $table->string('nom_agent');        
            $table->date('dateSortie');
            $table->string('libelle');
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
        Schema::dropIfExists('tmed_entete_sortie');
    }
}
