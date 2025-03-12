<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlaboResultatSpermeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //tentetelabo
        //id,refEnteteLabo,refNatureEchantillon,designation_valeur,author
        Schema::create('tlabo_resultat_sperme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteLabo')->constrained('tentetelabo')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refNatureEchantillon')->constrained('tlabo_nature_echantillon')->restrictOnUpdate()->restrictOnDelete();            
            $table->string('designation_valeur',50);
            $table->string('author',50);  
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
        Schema::dropIfExists('tlabo_resultat_sperme');
    }
}
