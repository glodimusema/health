<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdyalDetailSurveillanceDyalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdyal_detail_surveillance_dyal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refSurvDyalise')->constrained('tdyal_surveillance_dyalise')->restrictOnUpdate()->restrictOnDelete();
            $table->time('heures');
            $table->string('ta_dyal');
            $table->string('Bp');
            $table->string('Map');
            $table->string('HR');
            $table->double('poids');
            $table->double('temperature');
            $table->string('PA');
            $table->string('PV');
            $table->string('TMP');
            $table->string('QB');
            $table->string('QD');
            $table->string('TempsDialiat');
            $table->string('Observation');
            $table->string('auther');            
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
        Schema::dropIfExists('tdyal_detail_surveillance_dyal');
    }
}
