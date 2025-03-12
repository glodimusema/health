<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtTresoRubriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_treso_rubrique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refcateRubrik')->constrained('tt_treso_categorie_rubrique')->restrictOnUpdate()->restrictOnDelete();
            $table->string('desiRubriq',100);
            $table->string('codeRubriq',100);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tt_treso_rubrique')->insert([
            ['refcateRubrik' => 1,'desiRubriq' => 'CONSOMMABLE', 'codeRubriq' => 'CONS'],
            ['refcateRubrik' => 2,'desiRubriq' => 'MATERIEL DE BUREAU','codeRubriq' => 'MB']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tt_treso_rubrique');
    }
}
