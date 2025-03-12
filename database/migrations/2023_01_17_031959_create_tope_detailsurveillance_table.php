<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeDetailsurveillanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_detailsurveillance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteSurv')->constrained('tope_entetesurveillance')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refRubrique')->constrained('tope_rubriquesurveillance')->restrictOnUpdate()->restrictOnDelete();
            $table->string('libres'); 
            $table->string('encombres');
            $table->string('ampleERugiliere');
            $table->string('disphee');
            $table->string('lucide');
            $table->string('marcose');
            $table->string('propre');
            $table->string('souille');
            $table->string('normale');
            $table->string('nonretablie');
            $table->string('observationSurv'); 
            $table->string('Observe1');
            $table->string('Observe2');
            $table->string('Observe3');
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
        Schema::dropIfExists('tope_detailsurveillance');
    }
}
