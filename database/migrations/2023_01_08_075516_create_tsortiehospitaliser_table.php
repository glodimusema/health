<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsortiehospitaliserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsortiehospitaliser', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refHospitaliser')->constrained('thospitalisation')->restrictOnUpdate()->restrictOnDelete();           
            $table->date('dateSortie'); 
            $table->string('diagnosticSortie'); 
            $table->string('autreDetails');
            $table->string('medecin1');
            $table->string('specialite1');
            $table->string('cnom1');
            $table->string('medecin2');
            $table->string('specialite2');
            $table->string('cnom2');
            $table->string('medecin3');
            $table->string('specialite3');
            $table->string('cnom3');
            $table->date('dateRDV');
            $table->string('heureSortieHosp');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();


            // 'id','refHospitaliser','dateSortie','diagnosticSortie','autreDetails',
            // "medecin1","specialite1","cnom1","medecin2","specialite2","cnom2","medecin3","specialite3",
            // "cnom3","dateRDV","heureSortieHosp",'author'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tsortiehospitaliser');
    }
}
