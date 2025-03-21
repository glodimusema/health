<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeConsentementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_consentement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteOpe')->constrained('tope_enteteoperation')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateConsentement');
            $table->string('chirurgien');
            $table->string('anesthesiste');
            $table->string('intervention');
            $table->string('prevision');
            $table->string('actechirurgie');
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
        Schema::dropIfExists('tope_consentement');
    }
}
