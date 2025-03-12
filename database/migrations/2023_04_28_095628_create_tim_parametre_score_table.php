<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimParametreScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_parametre_score', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refLibelle')->constrained('tim_libelle_score')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refInterval')->constrained('tim_inverval')->restrictOnUpdate()->restrictOnDelete();
            $table->string('genre')->nullable();
            $table->string('score')->nullable();
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
        Schema::dropIfExists('tim_parametre_score');
    }
}
