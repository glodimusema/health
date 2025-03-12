<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiDetailSurveillancePlaieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospi_detail_surveillance_plaie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refSurvPlaie')->constrained('thospi_surveillance_plaie')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateSurv');
            $table->string('surfaceCm');
            $table->string('profondeurMin');
            $table->string('Pics');
            $table->string('BVA');
            $table->string('protocole');
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
        Schema::dropIfExists('thospi_detail_surveillance_plaie');
    }
}
