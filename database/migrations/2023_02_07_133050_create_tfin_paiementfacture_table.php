<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinPaiementfactureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_paiementfacture', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteFacturation')->constrained('tfin_entetefacturation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refBanque')->constrained('tconf_banque')->restrictOnUpdate()->restrictOnDelete();
            $table->string('numeroBordereau');
            $table->double('montantpaie'); 
            $table->double('montant_taux');            
            $table->date('datepaie');
            $table->string('modepaie');
            $table->string('libellepaie');
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
        Schema::dropIfExists('tfin_paiementfacture');
    }
}
