<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinSsouscompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_ssouscompte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refSousCompte')->constrained('tfin_souscompte')->restrictOnUpdate()->restrictOnDelete();     
            $table->string('nom_ssouscompte');
            $table->string('numero_ssouscompte');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tfin_ssouscompte')->insert([
            ['refSousCompte' => 1,'nom_ssouscompte' => 'BANQUE','numero_ssouscompte' => '52.01','author' => 'Admin'],
            ['refSousCompte' => 2,'nom_ssouscompte' => 'CAISSE','numero_ssouscompte' => '57.01','author' => 'Admin'],
            ['refSousCompte' => 3,'nom_ssouscompte' => 'CHARGES DIVERSES','numero_ssouscompte' => '60.01','author' => 'Admin'],
            ['refSousCompte' => 4,'nom_ssouscompte' => 'PRODUITS','numero_ssouscompte' => '70.01','author' => 'Admin'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfin_ssouscompte');
    }
}
