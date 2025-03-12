<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtTresoDetailEtatbesoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    //refEntete,refRubrique,Qte,PU  author

    public function up()
    {
        Schema::create('tt_treso_detail_etatbesoin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEntete')->constrained('tt_treso_entete_etatbesoin')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refRubrique')->constrained('tt_treso_rubrique')->restrictOnUpdate()->restrictOnDelete();
            $table->double('Qte');
            $table->double('PU');
            $table->string('service_beneficiaire',200);
            $table->string('author',200);
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
        Schema::dropIfExists('tt_treso_detail_etatbesoin');
    }
}
