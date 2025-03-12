<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeRubriquesurveillanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_rubriquesurveillance', function (Blueprint $table) {
            $table->id();
            $table->string('nom_rubliquesurv');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tope_rubriquesurveillance')->insert([
            ['nom_rubliquesurv' => 'Reubrique1'],
            ['nom_rubliquesurv' => 'Reubrique2']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tope_rubriquesurveillance');
    }
}
