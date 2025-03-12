<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdyalSurveillanceDyaliseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdyal_surveillance_dyalise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteDyalise')->constrained('tdyal_entete_dyalise')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypeMachine')->constrained('tdyal_type_machine')->restrictOnUpdate()->restrictOnDelete();
            $table->string('Bpo');
            $table->string('balus');
            $table->string('dialiseur');
            $table->string('poidsSec');
            $table->string('poidsAvant');
            $table->string('poidsApres');
            $table->string('fer');
            $table->string('infusion');
            $table->string('dialysate');
            $table->string('claurenceUree');
            $table->string('volumeSang');
            $table->string('kttinal');
            $table->string('instruction');
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
        Schema::dropIfExists('tdyal_surveillance_dyalise');
    }
}
