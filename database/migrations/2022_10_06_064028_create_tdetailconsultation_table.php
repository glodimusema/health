<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetdetailconsultationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdetailconsultation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteCons')->constrained('tenteteconsulter')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypeCons')->constrained('ttypeconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->string('plainte'); 
            $table->string('historique'); 
            $table->string('antecedent'); 
            $table->string('complementanamnese'); 
            $table->string('examenphysique'); 
            $table->string('diagnostiquePres'); 
            $table->date('dateDetailCons');     
            $table->string('AutresDiagnostics');        
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
           
        });
    }
//AutresDiagnostics
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tdetailconsultation');
    }
}
