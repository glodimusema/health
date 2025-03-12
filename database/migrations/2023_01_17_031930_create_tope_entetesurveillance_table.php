<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeEntetesurveillanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_entetesurveillance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAnesthesie')->constrained('tope_anesthesie')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refDepartement')->constrained('tope_departement')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateSurveillance'); 
            $table->string('chirurgien');
            $table->string('anesthesiste');
            $table->string('infirmierSalle');
            $table->string('heureAdmiSalle');
            $table->string('heureDebutInterv');
            $table->string('diagnosticOpe');
            $table->string('acteOpe');
            $table->string('heureFin');
            $table->string('autresCommentaires'); 
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
        Schema::dropIfExists('tope_entetesurveillance');
    }
}
