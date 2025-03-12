<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiActesmdecinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospi_actesmdecin', function (Blueprint $table) {
            $table->id();
            $table->string('refUnite');
            $table->string('refSscompte');
            $table->string('nom_acte');
            $table->double('prix_acte');
            $table->double('prix_convention');
            $table->string('code_acte');
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
        Schema::dropIfExists('thospi_actesmdecin');
    }
}
