<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospitalisationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospitalisation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refLit')->constrained('tlit')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refDetailCons')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateEntree'); 
            $table->string('diagnosticEntree'); 
            $table->string('observations');
            $table->date('dateHospi'); 
            $table->foreignId('refServiceHospi')->constrained('tfin_uniteproduction')->restrictOnUpdate()->restrictOnDelete();          
            $table->string('serviceOrigine');
            $table->string('TypeOrientationHosp');
            $table->string('statutHospi')->default('Encours');
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
        Schema::dropIfExists('thospitalisation');
    }
}
