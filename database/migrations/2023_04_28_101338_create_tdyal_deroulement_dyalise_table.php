<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdyalDeroulementDyaliseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdyal_deroulement_dyalise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteDyalise')->constrained('tdyal_entete_dyalise')->restrictOnUpdate()->restrictOnDelete();
            $table->string('heure',10);
            $table->string('ta',50);
            $table->string('bP',100);
            $table->string('mAp',100);
            $table->string('hR',100);
            $table->string('pA',100);
            $table->string('pV',10);
            $table->string('tMP',50);
            $table->string('qB',100);
            $table->string('qD',100);
            $table->string('uF',100);
            $table->string('observation',100);
            $table->string('author',100);
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
        Schema::dropIfExists('tdyal_deroulement_dyalise');
    }
}
