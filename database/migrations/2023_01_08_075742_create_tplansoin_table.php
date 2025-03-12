<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTplansoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tplansoin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refHospitaliser')->constrained('thospitalisation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refServiceSoin')->constrained('tservicesoin')->restrictOnUpdate()->restrictOnDelete();           
            $table->date('datePlan');                      
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
        Schema::dropIfExists('tplansoin');
    }
}
