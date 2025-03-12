<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagendamedecinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagendamedecin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();  
            $table->date('dateRDV', 250);
            $table->string('noms', 250);
            $table->string('contact', 250);
            $table->string('lieu', 250);
            $table->string('motif', 250);
            $table->string('statut')->default('Encours'); 
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
        Schema::dropIfExists('tagendamedecin');
    }
}
