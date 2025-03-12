<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeDetailoperationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_detailoperation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteOpe')->constrained('tope_enteteoperation')->restrictOnUpdate()->restrictOnDelete();
            $table->date('datedetailOpe');
            $table->string('diagnosticPresOpe');
            $table->string('anesthesiste');
            $table->string('chirurgien');
            $table->string('assistant');
            $table->string('infirmiercirculant');
            $table->string('diagnosticPostOpe');
            $table->string('perteSanguine');
            $table->string('Complication');
            $table->string('instructionPrescription');
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
        Schema::dropIfExists('tope_detailoperation');
    }
}
