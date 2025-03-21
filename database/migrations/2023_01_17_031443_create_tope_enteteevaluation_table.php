<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeEnteteevaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_enteteevaluation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteOpe')->constrained('tope_enteteoperation')->restrictOnUpdate()->restrictOnDelete();  
            $table->string('medecin');
            $table->string('anesthesiste');
            $table->string('infirmier');
            $table->date('dateEvaluation');
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
        Schema::dropIfExists('tope_enteteevaluation');
    }
}
