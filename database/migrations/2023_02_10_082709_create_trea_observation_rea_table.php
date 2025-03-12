<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreaObservationReaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trea_observation_rea', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteRea')->constrained('trea_entete_rea')->restrictOnUpdate()->restrictOnDelete();
            $table->string('detailObservation',100);
            $table->string('auther',100);
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
        Schema::dropIfExists('trea_observation_rea');
    }
}
