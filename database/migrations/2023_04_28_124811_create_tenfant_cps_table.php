<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenfantCpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenfant_cps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteVac')->constrained('tenfant_entete_vaccination')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refPeriode')->constrained('t_enfant_periode_c_p_s')->restrictOnUpdate()->restrictOnDelete();
            // $table->string('name_vaccin',50);
            $table->date('dateRecu',50);
            $table->double('poids');
            $table->string('author',50);
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
        Schema::dropIfExists('tenfant_cps');
    }
}
