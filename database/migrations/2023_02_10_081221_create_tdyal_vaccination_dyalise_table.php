<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdyalVaccinationDyaliseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdyal_vaccination_dyalise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteDyalise')->constrained('tdyal_entete_dyalise')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypeMachine')->constrained('tdyal_type_machine')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refVaccinDyalise')->constrained('tdyal_vaccin_dyalise')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateVaccin');
            $table->string('dose');
            $table->string('dosageLitre',100);
            $table->string('observation',100);
            $table->string('infirmier',100);
            $table->string('auther',100);            
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
        Schema::dropIfExists('tdyal_vaccination_dyalise');
    }
}
