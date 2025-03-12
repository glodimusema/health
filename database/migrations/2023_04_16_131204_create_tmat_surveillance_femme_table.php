<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmatSurveillanceFemmeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmat_surveillance_femme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refpatogramme')->constrained('tmat_partogramme')->restrictOnUpdate()->restrictOnDelete();
            $table->string('temps_ecoule')->nullable();
            $table->string('temps_rupture')->nullable();
            $table->string('saignement_vagin')->nullable();
            $table->string('nbresContraction')->nullable();
            $table->string('duree_contraction')->nullable();
            $table->string('poruit_coeur')->nullable();
            $table->string('temperature_oxilliare')->nullable();
            $table->string('pauls_battement')->nullable();
            $table->string('ta_sydolique')->nullable();
            $table->string('diurere_volume')->nullable();
            $table->string('dilatation_col')->nullable();    
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
        Schema::dropIfExists('tmat_surveillance_femme');
    }
}
