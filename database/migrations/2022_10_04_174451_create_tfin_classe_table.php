<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinClasseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_classe', function (Blueprint $table) {
            $table->id();
            $table->string('nom_classe');
            $table->string('numero_classe');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tfin_classe')->insert([
            ['nom_classe' => 'COMPTES DES RESSOURCES DURABLES','numero_classe' => '1', 'author' => 'Admin'],
            ['nom_classe' => 'COMPTE DES ACTIFS IMMOBILISES','numero_classe' => '2', 'author' => 'Admin'],
            ['nom_classe' => 'COMPTES DE STOCK','numero_classe' => '3', 'author' => 'Admin'],
            ['nom_classe' => 'COMPTES DE TIERS','numero_classe' => '4', 'author' => 'Admin'],
            ['nom_classe' => 'COMPTES DE TRESORERIE','numero_classe' => '5', 'author' => 'Admin'],
            ['nom_classe' => 'COMPTES DE CHARGES DES ACTIVITÉS ORDINAIRES','numero_classe' => '6', 'author' => 'Admin'],
            ['nom_classe' => 'COMPTES DE PRODUITS DES ACTIVITÉS ORDINAIRES','numero_classe' => '7', 'author' => 'Admin'],
            ['nom_classe' => 'COMPTES DES AUTRES CHARGES ET DES AUTRES PRODUITS','numero_classe' => '8', 'author' => 'Admin'],
            ['nom_classe' => 'COMPTES DES ENGAGEMENTS HORS BILAN ET COMPTES DE LA COMPTABILITE ANALYTIQUE DE GESTION','numero_classe' => '9', 'author' => 'Admin'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfin_classe');
    }
}
