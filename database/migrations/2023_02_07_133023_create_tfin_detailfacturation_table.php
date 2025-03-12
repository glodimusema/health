<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinDetailfacturationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_detailfacturation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteFacturation')->constrained('tfin_entetefacturation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refProduit')->constrained('tfin_produit')->restrictOnUpdate()->restrictOnDelete();
            $table->double('quantite');            
            $table->double('prixunitaire');
            $table->double('montant_taux');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }

    //montant_taux
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfin_detailfacturation');
    }
}
