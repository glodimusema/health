<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetdetailtriageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdetailtriage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteTriage')->constrained('tentetetriage')->restrictOnUpdate()->restrictOnDelete();
            $table->double('Poids');
            $table->double('Taille'); 
            $table->string('TA');  
            $table->double('Temperature');
            $table->double('FC'); 
            $table->double('FR'); 
            $table->double('Oxygene'); 
            $table->string('plainte_triage')->default(''); 
            $table->string('antecedent_trige')->default(''); 
            $table->string('cas_triage')->default('');          
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
        Schema::dropIfExists('tdetailtriage');
    }
}
