<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmedEnteteEntreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmed_entete_entree', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refFournisseur')->constrained('tfournisseur')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateEntree');
            $table->string('libelle');
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
        Schema::dropIfExists('tmed_entete_entree');
    }
}
