<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsoinhospitaliserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsoinhospitaliser', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refHospitaliser')->constrained('thospitalisation')->restrictOnUpdate()->restrictOnDelete();           
            $table->date('dateSoin');            
            $table->double('Temperature_hospi');
            $table->string('TA_hospi'); 
            $table->double('Poils_hospi');
            $table->double('Dieurese_hospi');  
            $table->double('Poids_hospi'); 
            $table->double('Taille_hospi'); 
            $table->double('FC_hospi');
            $table->double('FR_hospi'); 
            $table->double('Oxygene_hospi');  
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
        Schema::dropIfExists('tsoinhospitaliser');
    }
}
