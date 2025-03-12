<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinEntetefacturationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_entetefacturation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refMouvement')->constrained('tmouvement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refUniteProduction')->constrained('tfin_uniteproduction')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refMedecin')->constrained('tmedecin')->restrictOnUpdate()->restrictOnDelete();       
            $table->date('datefacture');
            $table->string('statut');
            $table->string('author');
            $table->double('montant')->default(0);
            $table->double('paie')->default(0);
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
        Schema::dropIfExists('tfin_entetefacturation');
    }
}
