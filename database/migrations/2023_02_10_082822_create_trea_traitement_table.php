<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreaTraitementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trea_traitement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteRea')->constrained('trea_entete_rea')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refMedicamnet')->constrained('tconf_medicament')->restrictOnUpdate()->restrictOnDelete();
            $table->string('posologie',100);
            $table->string('voire',100);
            $table->string('fait08h',100);
            $table->string('qte08h',100);
            $table->string('fait09h',100);
            $table->string('qte09h',100);
            $table->string('fait10h',100);
            $table->string('qte10h',100);
            $table->string('fait11h',100);
            $table->string('qte11h',100);
            $table->string('fait12h',100);
            $table->string('qte12h',100);
            $table->string('fait13h',100);
            $table->string('qte13h',100);
            $table->string('fait14h',100);
            $table->string('qte14h',100);
            $table->string('fait15h',100);
            $table->string('qte15h',100);
            $table->string('fait16h',100);
            $table->string('qte16h',100);
            $table->string('fait17h',100);
            $table->string('qte17h',100);
            $table->string('fait18h',100);
            $table->string('qte18h',100);
            $table->string('fait19h',100);
            $table->string('qte19h',100);
            $table->string('fait20h',100);
            $table->string('qte20h',100);
            $table->string('fait21h',100);
            $table->string('qte21h',100);
            $table->string('fait22h',100);
            $table->string('qte22h',100);
            $table->string('fait23h',100);
            $table->string('qte23h',100);
            $table->string('fait24h',100);
            $table->string('qte24h',100);
            $table->string('fait01h',100);
            $table->string('qte01h',100);
            $table->string('fait02h',100);
            $table->string('qte02h',100);
            $table->string('fait03h',100);
            $table->string('qte03h',100);
            $table->string('fait04h',100);
            $table->string('qte04h',100);
            $table->string('fait05h',100);
            $table->string('qte05h',100);
            $table->string('fait06h',100);
            $table->string('qte06h',100);
            $table->string('fait07h',100);
            $table->string('qte07h',100);
            $table->string('observatio0n',100);
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
        Schema::dropIfExists('trea_traitement');
    }
}
