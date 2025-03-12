<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiBilanHydriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospi_bilan_hydrique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refHospi')->constrained('thospitalisation')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateBilan');
            $table->double('calcul')->default(0);
            $table->double('totalEntree')->default(0);
            $table->double('totalSortie')->default(0);
            $table->string('hydrique');
            $table->double('poids')->default(0);
            $table->string('PerteInstalle')->default('0');
            $table->double('sc')->default(0);
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
        Schema::dropIfExists('thospi_bilan_hydrique');
    }
}
