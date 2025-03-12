<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiDetailActeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospi_detail_acte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refTraitem')->constrained('thospi_traitement_hospi')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refActeMedicale')->constrained('tfin_actesmedecin')->restrictOnUpdate()->restrictOnDelete();
            $table->string('description',100)->nullable();
            $table->string('fait08h',100)->nullable();
            $table->string('qte08h',100)->nullable();
            $table->string('fait09h',100)->nullable();
            $table->string('qte09h',100)->nullable();
            $table->string('fait10h',100)->nullable();
            $table->string('qte10h',100)->nullable();
            $table->string('fait11h',100)->nullable();
            $table->string('qte11h',100)->nullable();
            $table->string('fait12h',100)->nullable();
            $table->string('qte12h',100)->nullable();
            $table->string('fait13h',100)->nullable();
            $table->string('qte13h',100)->nullable();
            $table->string('fait14h',100)->nullable();
            $table->string('qte14h',100)->nullable();
            $table->string('fait15h',100)->nullable();
            $table->string('qte15h',100)->nullable();
            $table->string('fait16h',100)->nullable();
            $table->string('qte16h',100)->nullable();
            $table->string('fait17h',100)->nullable();
            $table->string('qte17h',100)->nullable();
            $table->string('fait18h',100)->nullable();
            $table->string('qte18h',100)->nullable();
            $table->string('fait19h',100)->nullable();
            $table->string('qte19h',100)->nullable();
            $table->string('fait20h',100)->nullable();
            $table->string('qte20h',100)->nullable();
            $table->string('fait21h',100)->nullable();
            $table->string('qte21h',100)->nullable();
            $table->string('fait22h',100)->nullable();
            $table->string('qte22h',100)->nullable();
            $table->string('fait23h',100)->nullable();
            $table->string('qte23h',100)->nullable();
            $table->string('fait24h',100)->nullable();
            $table->string('qte24h',100)->nullable();
            $table->string('fait01h',100)->nullable();
            $table->string('qte01h',100)->nullable();
            $table->string('fait02h',100)->nullable();
            $table->string('qte02h',100)->nullable();
            $table->string('fait03h',100)->nullable();
            $table->string('qte03h',100)->nullable();
            $table->string('fait04h',100)->nullable();
            $table->string('qte04h',100)->nullable();
            $table->string('fait05h',100)->nullable();
            $table->string('qte05h',100)->nullable();
            $table->string('fait06h',100)->nullable();
            $table->string('qte06h',100)->nullable();
            $table->string('fait07h',100)->nullable();
            $table->string('qte07h',100)->nullable();
            $table->string('author',100)->nullable();
            $table->string('observation',100)->nullable();
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
        Schema::dropIfExists('thospi_detail_acte');
    }
}
