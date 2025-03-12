<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimRectosigmoidocopieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_rectosigmoidocopie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refImagerie')->constrained('tim_imagerie')->restrictOnUpdate()->restrictOnDelete();
            $table->String('inspection');
            $table->string('toucherRectal')->nullable();
            $table->string('anuscopie')->nullable();
            $table->string('rectosigmoidoscopie')->nullable();
            $table->string('biopsies')->nullable();
            $table->string('image_rectosig')->nullable();
            $table->string('conclusion')->nullable();
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
        Schema::dropIfExists('tim_rectosigmoidocopie');
    }
}
