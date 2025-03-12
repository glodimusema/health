<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlaboDetailExamencoloreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id,refResultatBacterie,refExamenColore,author
        Schema::create('tlabo_detail_examencolore', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refResultatBacterie')->constrained('tlabo_resultat_bacteriologie')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refExamenColore')->constrained('tlabo_examencolore')->restrictOnUpdate()->restrictOnDelete();
            $table->string('author',50); 
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
        Schema::dropIfExists('tlabo_detail_examencolore');
    }
}
