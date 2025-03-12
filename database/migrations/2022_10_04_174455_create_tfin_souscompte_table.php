<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinSouscompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_souscompte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCompte')->constrained('tfin_compte')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nom_souscompte');
            $table->string('numero_souscompte');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tfin_souscompte')->insert([
            ['refCompte' => 1,'nom_souscompte' => 'BANQUE','numero_souscompte' => '52.0','author' => 'Admin'],
            ['refCompte' => 2,'nom_souscompte' => 'CAISSE','numero_souscompte' => '57.0','author' => 'Admin'],
            ['refCompte' => 3,'nom_souscompte' => 'CHARGES DIVERSES','numero_souscompte' => '60.0','author' => 'Admin'],
            ['refCompte' => 4,'nom_souscompte' => 'PRODUITS','numero_souscompte' => '70.0','author' => 'Admin'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfin_souscompte');
    }
}
