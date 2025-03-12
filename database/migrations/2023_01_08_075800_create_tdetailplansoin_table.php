<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdetailplansoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdetailplansoin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refPlanSoin')->constrained('tplansoin')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateDetailPlan');
            $table->string('heure');  
            $table->string('probleme');          
            $table->double('Temperature_plan');
            $table->string('PIS_plan');
            $table->string('PA_plan');           
            $table->double('FC_plan');
            $table->double('FR_plan');              
            $table->string('besoins_plan');
            $table->string('diagnostic_plan');
            $table->string('objectif_plan');
            $table->string('intervension_plan');
            $table->string('evaluation_plan');
            $table->string('infirmier_plan');                          
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
        Schema::dropIfExists('tdetailplansoin');
    }
}
