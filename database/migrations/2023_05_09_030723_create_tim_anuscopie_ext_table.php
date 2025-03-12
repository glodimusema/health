<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimAnuscopieExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_anuscopie_ext', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refImagerie')->constrained('tim_imagerie_ext')->restrictOnUpdate()->restrictOnDelete();
            $table->String('inspection',50);
            $table->string('toucherRectal',50);
            $table->string('anuscopie',50);
            $table->string('conclusion',50);
            $table->string('photo_anuscopie',50);
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
        Schema::dropIfExists('tim_anuscopie_ext');
    }
}
