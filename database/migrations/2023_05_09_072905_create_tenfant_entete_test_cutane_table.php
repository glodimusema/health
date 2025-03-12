<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenfantEnteteTestCutaneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenfant_entete_test_cutane', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailCons')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateTest');
            $table->string('medecinDemandeur')->default('Encours');
            $table->string('conclusionTest')->default('Encours');
            $table->string('clinique')->default('Encours');
            $table->string('examinateur')->default('Encours');
            $table->string('specialite')->default('Encours');
            $table->string('cNom')->default('Encours');
            $table->string('author')->default('Encours');
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
        Schema::dropIfExists('tenfant_entete_test_cutane');
    }
}
