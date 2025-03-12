<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMerePeriodeVacciniereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mere_periode_vacciniere', function (Blueprint $table) {
            $table->id();
            $table->string('nom_periode');
            $table->string('dure_semsuie');
            $table->string('author');  
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('t_mere_periode_vacciniere')->insert([
            ['nom_periode' => 'VAT1', 'dure_semsuie' => '0', 'author' => 'Admin'],
            ['nom_periode' => 'VAT2', 'dure_semsuie' => '0', 'author' => 'Admin'],
            ['nom_periode' => 'VAT3', 'dure_semsuie' => '0', 'author' => 'Admin'],
            ['nom_periode' => 'VAT4', 'dure_semsuie' => '0', 'author' => 'Admin'],
            ['nom_periode' => 'VAT5', 'dure_semsuie' => '0', 'author' => 'Admin'],
            ['nom_periode' => 'Complétement Vaccinée', 'dure_semsuie' => '0', 'author' => 'Admin']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_mere_periode_vacciniere');
    }
}
