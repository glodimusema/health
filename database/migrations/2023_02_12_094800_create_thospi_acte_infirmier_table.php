<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiActeInfirmierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospi_acte_infirmier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refHospi')->constrained('thospitalisation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refActeMedical')->constrained('tfin_actesmedecin')->restrictOnUpdate()->restrictOnDelete();
            $table->string('Description',100);
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
        Schema::dropIfExists('thospi_acte_infirmier');
    }
}
