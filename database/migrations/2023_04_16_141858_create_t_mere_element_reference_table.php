<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMereElementReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mere_element_reference', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCPN')->constrained('t_mere_consultation_prenatale')->restrictOnUpdate()->restrictOnDelete();
            $table->datetime('date_elementRef')->nullable();
            $table->string('autresProbleme')->nullable();
            $table->string('traitement')->nullable();         
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
        Schema::dropIfExists('t_mere_element_reference');
    }
}
