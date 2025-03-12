<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiAppreciationInfirmierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospi_appreciation_infirmier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refHospi')->constrained('thospitalisation')->restrictOnUpdate()->restrictOnDelete();
            $table->string('degreSatisfaction');
            $table->string('remarques');
            $table->string('sugestion');
            $table->string('infirmier');
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
        Schema::dropIfExists('thospi_appreciation_infirmier');
    }
}
