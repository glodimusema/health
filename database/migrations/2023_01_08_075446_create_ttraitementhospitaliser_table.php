<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtraitementhospitaliserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttraitementhospitaliser', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refHospitaliser')->constrained('thospitalisation')->restrictOnUpdate()->restrictOnDelete();           
            $table->integer('refMedeicament');
            $table->date('dateTraitement'); 
            $table->string('dose'); 
            $table->string('voie');
            $table->string('autreDetails');              
            $table->string('moment');              
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
        Schema::dropIfExists('ttraitementhospitaliser');
    }
}
