<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenfantRendevousEnfantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenfant_rendevous_enfant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEntete')->constrained('tenfant_entete_vaccination')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refPeriode')->constrained('tenfant_periode_vac_enfant')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateRdv',50);
            $table->string('etatRdv',50);
            $table->string('author',100);
            $table->integer('compteurRandezvous');
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
        Schema::dropIfExists('tenfant_rendevous_enfant');
    }
}
