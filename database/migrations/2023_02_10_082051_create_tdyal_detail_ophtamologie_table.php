<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdyalDetailOphtamologieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdyal_detail_ophtamologie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailConst')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateOphta',100);
            $table->string('visionDeLoin_ob',100);
            $table->string('visionDePres_ob',100);
            $table->string('visionDeLoin_oG',100);
            $table->string('visionDePres_OG',100);
            $table->string('observation',100);
            $table->string('paut',100);
            $table->string('branche',100);
            $table->string('entredragoire',100);
            $table->string('auther',100);
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
        Schema::dropIfExists('tdyal_detail_ophtamologie');
    }
}
