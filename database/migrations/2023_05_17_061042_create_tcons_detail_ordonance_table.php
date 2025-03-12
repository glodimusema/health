<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconsDetailOrdonanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id,refEnteteOrdonance,medicaments,posologie,autresdetails,author
        Schema::create('tcons_detail_ordonance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteOrdonance')->constrained('tcons_entete_ordonance')->restrictOnUpdate()->restrictOnDelete();
            $table->string('medicaments');            
            $table->string('posologie'); 
            $table->string('autresdetails');          
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
        Schema::dropIfExists('tcons_detail_ordonance');
    }
}
