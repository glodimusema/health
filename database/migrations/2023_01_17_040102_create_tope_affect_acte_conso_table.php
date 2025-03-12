<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeAffectActeConsoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_affect_acte_conso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteConso')->constrained('tope_enteteoperation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refActeOpratoire')->constrained('tfin_actesmedecin')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tope_affect_acte_conso');
    }
}
