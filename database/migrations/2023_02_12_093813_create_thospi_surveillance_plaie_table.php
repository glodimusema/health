<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiSurveillancePlaieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospi_surveillance_plaie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refHospi')->constrained('thospitalisation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypePlaie')->constrained('thospi_type_plaie')->restrictOnUpdate()->restrictOnDelete();
            $table->string('localisation');
            $table->string('pourcentageNoire');
            $table->string('pourcentageMarron');
            $table->string('pourcentageJaune');
            $table->string('pourcentageRouge');
            $table->string('pourcentageRose');
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
        Schema::dropIfExists('thospi_surveillance_plaie');
    }
}
