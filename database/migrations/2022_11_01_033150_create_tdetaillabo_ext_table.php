<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetdetaillaboExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdetaillabo_ext', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteLabo')->constrained('tentetelabo_ext')->restrictOnUpdate()->restrictOnDelete();  
            $table->integer('refValeur');
            $table->string('libelle', 250);
            $table->string('observation', 250);
            $table->string('natureechantillon', 250);
            $table->string('methode', 250);
            $table->string('commentaire', 250);
            $table->string('author', 250);
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
        Schema::dropIfExists('tdetaillabo_ext');
    }
}
