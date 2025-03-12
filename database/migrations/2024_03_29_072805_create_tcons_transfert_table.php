<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconsTransfertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcons_transfert', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailCons')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_admission');
            $table->string('heure_admission');
            $table->string('diagnostic_tranfert');
            $table->string('bilan_tranfert');
            $table->string('traitement_tranfert');
            $table->string('motif_tranfert');
            $table->date('date_transfert');
            $table->string('heure_transfert');
            $table->string('hopital_transfert',100);
            $table->string('medecin_transfert',100);
            $table->string('specialite_transfert',100);
            $table->string('cnom_transfert',100);
            $table->string('author',100);
            $table->timestamps();
        });
    }

    //id, refDetailCons,date_admission,heure_admission,diagnostic_tranfert,bilan_tranfert,traitement_tranfert,
    //motif_tranfert,date_transfert,heure_transfert,medecin,specialite,cnom,author

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcons_transfert');
    }
}
