<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmatapgarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmatapgar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refpatogramme')->constrained('tmat_partogramme')->restrictOnUpdate()->restrictOnDelete();
            $table->string('respiration');
            $table->string('Fc_Apgar');
            $table->string('coloration');  
            $table->string('refexes');
            $table->string('toms_musculaire');
            $table->string('temps_APGAR');  
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
        Schema::dropIfExists('tmatapgar');
    }
}
