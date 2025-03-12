<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_produit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refTypeProduit')->constrained('tfin_typeproduit')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refSscompte')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refCategorieSociete')->constrained('tfin_categorie_societe')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nom_produit');
            $table->double('prix_produit');
            $table->double('prix_convention');
            $table->string('code_produit');
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
        Schema::dropIfExists('tfin_produit');
    }
}
