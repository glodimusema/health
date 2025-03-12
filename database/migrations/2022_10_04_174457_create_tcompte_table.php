<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcompte', function (Blueprint $table) {
            $table->id();
            $table->string('designation'); 
            $table->foreignId('refMvt')->constrained('ttypemouvement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refSscompte')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
        DB::table('tcompte')->insert([
            ['designation' => 'VENTE DES SERVICES','refMvt' => 1,'refSscompte' => 4],
            ['designation' => 'ACHAT MATRIELS DE BUREAU','refMvt' => 2,'refSscompte' => 3],
            ['designation' => 'PAIEMENT SALIRE DES AGENTS','refMvt' => 2,'refSscompte' => 3],
            ['designation' => 'PAIEMENT TAXE ET IMPOT','refMvt' => 2,'refSscompte' => 3],
            ['designation' => 'CHARGES DIVERSES','refMvt' => 2,'refSscompte' => 3],
        ]);
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
