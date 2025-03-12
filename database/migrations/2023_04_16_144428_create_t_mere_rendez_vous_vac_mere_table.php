<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMereRendezVousVacMereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mere_rendez_vous_vac_mere', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCPN')->constrained('t_mere_consultation_prenatale')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refPeriode')->constrained('t_mere_periode_vacciniere')->restrictOnUpdate()->restrictOnDelete();
            $table->datetime('date_RDV')->nullable();
            $table->integer('etatRdv')->nullable();
            $table->string('compteurRDV')->nullable();
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
        Schema::dropIfExists('t_mere_rendez_vous_vac_mere');
    }
}
