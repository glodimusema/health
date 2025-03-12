<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimRectoscopieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_rectoscopie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refImagerie')->constrained('tim_imagerie')->restrictOnUpdate()->restrictOnDelete();
            $table->String('inspection');
            $table->string('toucherRectal')->nullable();
            $table->string('anuscopie')->nullable();
            $table->string('rectoscopie')->nullable();
            $table->string('image_rectoscopie')->nullable();
            $table->string('conclusion_recto')->nullable();
            $table->string('author')->nullable();
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
        Schema::dropIfExists('tim_rectoscopie');
    }
}
