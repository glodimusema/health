<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiDetailBilanHydriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospi_detail_bilan_hydrique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refBilan')->constrained('thospi_bilan_hydrique')->restrictOnUpdate()->restrictOnDelete();
            $table->string('heure');
            $table->string('perfusion');
            $table->string('peros');
            $table->double('qte');
            $table->string('drains');
            $table->string('sng');
            $table->string('duirise');
            $table->string('selles');
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
        Schema::dropIfExists('thospi_detail_bilan_hydrique');
    }
}
