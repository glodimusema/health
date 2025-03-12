<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsuivihospitaliserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsuivihospitaliser', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('refHospitaliser')->constrained('thospitalisation')->restrictOnUpdate()->restrictOnDelete();           
            $table->date('dateDetail');            
            $table->string('observationsInfirmier');
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
        Schema::dropIfExists('tsuivihospitaliser');
    }
}
