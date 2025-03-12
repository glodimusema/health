<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetentetelaboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tentetelabo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEntetePrelevement')->constrained('tlabo_entete_prelevement')->restrictOnUpdate()->restrictOnDelete();
            $table->integer('refExamen');
            $table->date('dateLabo');
            $table->string('statutentetelabo')->default('Attente');
            $table->string('serviceProvenance');
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
        Schema::dropIfExists('tentetelabo');
    }
}
