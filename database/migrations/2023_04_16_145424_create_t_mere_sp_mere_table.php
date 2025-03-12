<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMereSpMereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mere_sp_mere', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCPN')->constrained('t_mere_consultation_prenatale')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refPeriode_sp')->constrained('t_mere_periode_sp')->restrictOnUpdate()->restrictOnDelete();
            $table->datetime('date_recuSp')->nullable();
            $table->double('poids_sp')->nullable();  
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
        Schema::dropIfExists('t_mere_sp_mere');
    }
}
