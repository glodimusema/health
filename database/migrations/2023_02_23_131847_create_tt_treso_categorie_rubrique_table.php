<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtTresoCategorieRubriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_treso_categorie_rubrique', function (Blueprint $table) {
            $table->id();
            $table->string('NomCateRubrique');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tt_treso_categorie_rubrique')->insert([
            ['NomCateRubrique' => 'CONSOMMABLE'],
            ['NomCateRubrique' => 'MATERIEL DE BUREAU']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tt_treso_categorie_rubrique');
    }
}
