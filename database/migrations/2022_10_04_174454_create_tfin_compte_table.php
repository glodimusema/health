<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinCompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_compte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refClasse')->constrained('tfin_classe')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypecompte')->constrained('tfin_typecompte')->restrictOnUpdate()->restrictOnDelete();
            $table->integer('refPosition'); 
            $table->string('nom_compte');
            $table->string('numero_compte');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tfin_compte')->insert([
            ['refClasse' => 5,'refTypecompte' => 1,'refPosition' => 1,'nom_compte' => 'BANQUE','numero_compte' => '52','author' => 'Admin'],
            ['refClasse' => 5,'refTypecompte' => 1,'refPosition' => 1,'nom_compte' => 'CAISSE','numero_compte' => '57','author' => 'Admin'],
            ['refClasse' => 6,'refTypecompte' => 1,'refPosition' => 1,'nom_compte' => 'CHARGES DIVERSES','numero_compte' => '60','author' => 'Admin'],
            ['refClasse' => 7,'refTypecompte' => 1,'refPosition' => 1,'nom_compte' => 'PRODUITS','numero_compte' => '70','author' => 'Admin'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfin_compte');
    }
}
