<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimScoreProbabiliteScoreExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_score_probabilite_score_ext', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refImagerie')->constrained('tim_imagerie_ext')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refparamScore')->constrained('tim_parametre_score')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tim_score_probabilite_score_ext');
    }
}
