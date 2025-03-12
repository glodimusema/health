<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMerePeniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id,refCPN,refPeriode_Peni,date_recusPeni,poids_Peni,author
        Schema::create('t_mere_peni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCPN')->constrained('t_mere_consultation_prenatale')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refPeriode_Peni')->constrained('t_periode_peni_mere')->restrictOnUpdate()->restrictOnDelete();
            $table->datetime('date_recusPeni')->nullable();
            $table->double('poids_Peni')->nullable();  
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
        //t_mere_consultation_prenatale
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_mere_peni');
    }
}
