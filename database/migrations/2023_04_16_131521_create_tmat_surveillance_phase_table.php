<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmatSurveillancePhaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmat_surveillance_phase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refpatogramme')->constrained('tmat_partogramme')->restrictOnUpdate()->restrictOnDelete();
            $table->string('heureReelle')->nullable();
            $table->string('dilatation')->nullable();
            $table->string('Engagement')->nullable();  
            $table->string('incident')->nullable();
            $table->string('bcf')->nullable();
            $table->string('tempsEcoule')->nullable();
            $table->string('contractionsUterines')->nullable();  
            $table->string('duree_contraction')->nullable();
            $table->string('membrane')->nullable();
            $table->string('LA_aspect')->nullable();
            $table->string('Pertes_sang')->nullable();  
            $table->string('Temps_oxillaire')->nullable();
            $table->string('diurese')->nullable();
            $table->string('ocytocine_u')->nullable();
            $table->string('ocytocine_ghes')->nullable();
            $table->string('medicaments_inject')->nullable();  
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
        Schema::dropIfExists('tmat_surveillance_phase');
    }
}
