<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeEnteteconsommationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_enteteconsommation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteOpe')->constrained('tope_enteteoperation')->restrictOnUpdate()->restrictOnDelete();
            $table->integer('refIntervention');
            $table->integer('refServiceHopital');
            $table->integer('refLit');
            $table->date('dateIntervension');
            $table->string('infirmier');
            $table->string('chirurgien');
            $table->string('anesthesiste');
            $table->string('diagnosticOpe');
            $table->string('priseenCharge');
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
        Schema::dropIfExists('tope_enteteconsommation');
    }
}
