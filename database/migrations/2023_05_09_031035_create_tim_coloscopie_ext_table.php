<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimColoscopieExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_coloscopie_ext', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refImagerie')->constrained('tim_imagerie_ext')->restrictOnUpdate()->restrictOnDelete();
            $table->String('inspection');
            $table->string('toucherRectal',50);
            $table->string('anuscopie',50);
            $table->string('coloscopie',50);
            $table->string('biopsies',50);
            $table->string('image_colorscopie');
            $table->string('conclusion');
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
        Schema::dropIfExists('tim_coloscopie_ext');
    }
}
