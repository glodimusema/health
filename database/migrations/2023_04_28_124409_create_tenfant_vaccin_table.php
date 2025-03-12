<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenfantVaccinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenfant_vaccin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCategorie')->constrained('tenfant_categorie')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refPeriode')->constrained('tenfant_periode_vac_enfant')->restrictOnUpdate()->restrictOnDelete();
            $table->string('name_vaccin',50);
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
        Schema::dropIfExists('tenfant_vaccin');
    }
}
