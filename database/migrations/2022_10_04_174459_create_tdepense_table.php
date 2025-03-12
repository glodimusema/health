<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetdepenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdepense', function (Blueprint $table) {
            $table->id();
            $table->double('montant');
            $table->string('montantLettre');
            $table->string('motif'); 
            $table->date('dateOperation');
            $table->foreignId('refMvt')->constrained('ttypemouvement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refCompte')->constrained('tcompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refBanque')->constrained('tconf_banque')->restrictOnUpdate()->restrictOnDelete();
            $table->string('modepaie');
            $table->string('numeroBordereau');
            $table->double('taux_dujour');
            $table->string('AcquitterPar'); 
            $table->string('StatutAcquitterPar'); 
            $table->date('DateAcquitterPar'); 
            $table->string('ApproCoordi'); 
            $table->string('StatutApproCoordi'); 
            $table->date('DateApproCoordi'); 
            $table->string('numeroBE');
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
        Schema::dropIfExists('tdetailproduit');
    }
}
